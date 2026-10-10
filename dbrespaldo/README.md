# Módulo de Respaldo y Migración a la Nube (dbrespaldo)

Este directorio contiene herramientas automatizadas para respaldar la base de datos local `gim360` y subirla / sincronizarla con la base de datos de producción o pruebas en la nube (MySQL / MariaDB en cPanel, AWS RDS, DigitalOcean, Railway, etc.).

---

## Archivos en este directorio

1. **`subir_db_nube.sh`**: Script en Bash principal que exporta la base de datos local con `mysqldump` / `mariadb-dump`, sanitiza las incompatibilidades cloud (elimina DEFINER, sandbox y normaliza charsets) y sube la base a la nube.
2. **`subir_db_nube.php`**: Versión en PHP CLI para entornos donde se prefiera o requiera ejecución mediante PHP.
3. **`config_nube.env.example`**: Plantilla con las variables necesarias para conectarse a la nube.
4. **`config_nube.env`**: Archivo (opcional y personal) con tus credenciales reales. **Protegido por `.gitignore`, nunca se sube a GitHub.**
5. **`gim360.sql`**: Volcado SQL sincronizado y listo para desplegar.

---

## Modo de Uso Rápido

### Opción 1: Con archivo de configuración (Recomendado)

1. Copia la plantilla de configuración:
   ```bash
   cp dbrespaldo/config_nube.env.example dbrespaldo/config_nube.env
   ```

2. Edita `dbrespaldo/config_nube.env` y coloca las credenciales de tu servidor en la nube:
   ```env
   CLOUD_DB_HOST="tu_servidor_en_la_nube.com"
   CLOUD_DB_PORT="3306"
   CLOUD_DB_NAME="gim360"
   CLOUD_DB_USER="tu_usuario_remoto"
   CLOUD_DB_PASS="tu_contraseña_remota"
   CLOUD_DB_SSL="false"
   ```

3. Ejecuta el script:
   ```bash
   ./dbrespaldo/subir_db_nube.sh
   ```

---

### Opción 2: Pasando credenciales por línea de comandos

Puedes pasar los datos directamente sin guardar archivos:
```bash
./dbrespaldo/subir_db_nube.sh -h db.miempresa.com -u usuario_nube -p "mi_password" -d gim360
```

Con PHP CLI:
```bash
php dbrespaldo/subir_db_nube.php --host=db.miempresa.com --user=usuario_nube --pass="mi_password" --db=gim360
```

---

### Opción 3: Limpiar base remota antes de subir (`--limpiar` / `--reset`)

Si deseas que la base en la nube quede exactamente idéntica a la local (eliminando tablas y vistas viejas que hayan sido renombradas o eliminadas):
```bash
./dbrespaldo/subir_db_nube.sh --limpiar
```

O con PHP:
```bash
php dbrespaldo/subir_db_nube.php --limpiar
```

---

### Opción 4: Solo verificar conexión remota (`--verificar`)

Para comprobar si las credenciales de la nube son correctas y ver qué tablas existen actualmente sin realizar cambios:
```bash
./dbrespaldo/subir_db_nube.sh --verificar
```

O con PHP:
```bash
php dbrespaldo/subir_db_nube.php --verificar
```

---

### Opción 5: Usar archivo SQL existente sin exportar de nuevo (`--usar-sql`)

Si deseas subir el archivo `gim360.sql` directamente sin necesidad de volver a volcar la base local:
```bash
./dbrespaldo/subir_db_nube.sh --usar-sql
```

O especificando un archivo con `-f`:
```bash
./dbrespaldo/subir_db_nube.sh -f /ruta/a/mi_archivo.sql
```

---

### Opción 6: Solo generar respaldo local limpio (`--solo-exportar`)

Si únicamente deseas crear un respaldo fechado de la base local y actualizar `gim360.sql`:
```bash
./dbrespaldo/subir_db_nube.sh --solo-exportar
```
O con PHP:
```bash
php dbrespaldo/subir_db_nube.php --solo-exportar
```

---

## Opciones Completas de `subir_db_nube.sh`

| Parámetro | Descripción |
|---|---|
| `-h, --host HOST` | Host o IP del servidor MySQL remoto |
| `-P, --port PUERTO` | Puerto remoto (por defecto: 3306) |
| `-u, --user USUARIO` | Usuario de MySQL remoto |
| `-p, --pass PASSWORD` | Contraseña de MySQL remoto |
| `-d, --db NOMBRE_BD` | Nombre de la base de datos remota (por defecto: `gim360`) |
| `--ssl` | Habilitar SSL obligatorio (`--ssl-mode=REQUIRED`) |
| `--crear-db` | Ejecutar `CREATE DATABASE IF NOT EXISTS` en la nube si se tienen permisos |
| `--limpiar, --reset` | Eliminar tablas y vistas previas en la base remota antes de importar |
| `--verificar, --check` | Probar conexión remota e informar estado sin modificar nada |
| `-f, --file ARCHIVO` | Usar un archivo SQL personalizado en lugar de exportar |
| `--usar-sql` | Usar el archivo canonical `gim360.sql` del proyecto |
| `--solo-exportar` | Generar únicamente respaldo local sin subirlo |
| `-y, --yes, --force` | Omitir confirmaciones interactivas |
| `--help` | Mostrar menú de ayuda y ejemplos |

---

## Características de Seguridad y Optimización Cloud

- **Sin restricciones DEFINER**: Elimina automáticamente bloques `DEFINER` y `SQL SECURITY DEFINER` para evitar el error `1227 (Access denied; SUPER privilege)` en MySQL/MariaDB gestionados en la nube.
- **Sin directivas propietarias**: Remueve `/*M!999999\- enable the sandbox mode */` incompatible con motores MySQL estándar.
- **Sin bloqueos innecesarios**: No utiliza `LOCK TABLES` / `UNLOCK TABLES` para evitar el error `1044` en usuarios con privilegios limitados.
- **Integridad referencial asegurada**: Desactiva temporalmente las comprobaciones foráneas durante la importación (`FOREIGN_KEY_CHECKS=0`), permitiendo recrear tablas relacionadas sin conflictos de orden.
- **Transmisión de grandes paquetes**: Emplea `--max-allowed-packet=64M` y `--binary-mode` para salvaguardar fotos de equipos y ejercicios sin truncamiento.
- **Protección de contraseñas**: Utiliza `MYSQL_PWD` para evitar exponer contraseñas en la lista de procesos (`ps`) y el aviso de advertencia de MySQL en consola.
- **Sincronización automática**: Al exportar, actualiza simultáneamente `dbrespaldo/gim360-YYYY-MM-DD.sql`, `dbrespaldo/gim360.sql` y `gim360.sql` en la raíz.
