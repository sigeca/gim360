# Módulo de Respaldo y Migración a la Nube (dbrespaldo)

Este directorio contiene herramientas automatizadas para respaldar la base de datos local `gim360` y subirla / sincronizarla con la base de datos de producción o pruebas en la nube.

---

## Archivos en este directorio

1. **`subir_db_nube.sh`**: Script en Bash que exporta la base de datos local con `mysqldump` / `mariadb-dump` y la sube al servidor MySQL en la nube.
2. **`subir_db_nube.php`**: Versión alternativa en PHP para entornos donde se prefiera o requiera ejecución mediante PHP CLI.
3. **`config_nube.env.example`**: Plantilla con las variables necesarias para conectarse a la nube.
4. **`config_nube.env`**: Archivo (opcional y personal) con tus credenciales reales. **Está protegido por `.gitignore` y nunca se subirá a GitHub.**

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

Con PHP:
```bash
php dbrespaldo/subir_db_nube.php --host=db.miempresa.com --user=usuario_nube --pass="mi_password" --db=gim360
```

---

### Opción 3: Modo interactivo

Si ejecutas el script en tu terminal sin parámetros y sin `config_nube.env`:
```bash
./dbrespaldo/subir_db_nube.sh
```
El script te solicitará los datos de la nube por pantalla y te preguntará si deseas guardarlos en `config_nube.env`.

---

### Opción 4: Solo generar respaldo local

Si únicamente deseas crear un respaldo fechado de la base local y actualizar `gim360.sql`:
```bash
./dbrespaldo/subir_db_nube.sh --solo-exportar
```
O con PHP:
```bash
php dbrespaldo/subir_db_nube.php --solo-exportar
```

---

## Características de Seguridad y Optimización

- **Optimización de volcado**: Usa `--single-transaction`, `--quick`, `--routines`, `--triggers` y `--hex-blob` para evitar bloqueos y asegurar integridad referencial.
- **Detección automática local**: Lee las credenciales locales directamente del archivo `.env` del proyecto.
- **Sincronización automática**: Al exportar, actualiza automáticamente `gim360_ultimo.sql` y `gim360.sql` en la raíz del proyecto.
- **Protección de credenciales**: `config_nube.env` está añadido al `.gitignore` para evitar fugas de información hacia GitHub.
