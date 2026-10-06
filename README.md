# GIM360 - Sistema de Gestión en CodeIgniter 4

Sistema de información y gestión desarrollado con el framework **CodeIgniter 4** (PHP 8.4) y conectado a una base de datos local **MySQL / MariaDB** denominada `gim360`.

---

## 📋 Estructura de la Base de Datos (`gim360`)

El sistema gestiona 9 tablas normalizadas con claves foráneas e integridad referencial en cascada:

1. **`sexo`**: `idsexo`, `nombre`
2. **`persona`**: `idpersona`, `cedula`, `nombres`, `fechanacimiento`, `idsexo`
3. **`correo`**: `idcorreo`, `idpersona`, `correo`, `fechaoptencion`
4. **`direccion`**: `iddireccion`, `idpersona`, `direccion`
5. **`cliente`**: `idcliente`, `idpersona`
6. **`estadocivil`**: `idestadocivil`, `nombre`
7. **`estadocivilpersona`**: `idestadocivilpersona`, `idpersona`, `idestadocivil`
8. **`genero`**: `idgenero`, `nombre`
9. **`generopersona`**: `idgeneropersona`, `idpersona`, `idgenero`

El script completo de creación y datos iniciales se encuentra en [gim360.sql](file:///var/www/html/gim360/gim360.sql).

---

## 🚀 Acceso al Sistema

### 1. A través de Servidor Apache (Localhost)
El proyecto está ubicado en `/var/www/html/gim360`:
- **URL Principal:** [http://localhost/gim360/](http://localhost/gim360/)
- **Gestión de Personas:** [http://localhost/gim360/index.php/persona](http://localhost/gim360/index.php/persona)
- **Gestión de Clientes:** [http://localhost/gim360/index.php/cliente](http://localhost/gim360/index.php/cliente)
- **Gestión de Correos:** [http://localhost/gim360/index.php/correo](http://localhost/gim360/index.php/correo)
- **Gestión de Direcciones:** [http://localhost/gim360/index.php/direccion](http://localhost/gim360/index.php/direccion)
- **Catálogo de Sexos:** [http://localhost/gim360/index.php/sexo](http://localhost/gim360/index.php/sexo)
- **Catálogo Estados Civiles:** [http://localhost/gim360/index.php/estadocivil](http://localhost/gim360/index.php/estadocivil)
- **Catálogo Géneros:** [http://localhost/gim360/index.php/genero](http://localhost/gim360/index.php/genero)

### 2. A través de CodeIgniter Spark
Si desea ejecutar el servidor de desarrollo integrado de CodeIgniter:
```bash
php spark serve --port 8080
```
Luego ingresar a: `http://localhost:8080/`

---

## 🛠️ Configuración de Base de Datos

Archivo `.env` y `app/Config/Database.php`:
- **Hostname:** `localhost`
- **Database:** `gim360`
- **Username:** `root`
- **Password:** `PIWIIB1234`
- **DBDriver:** `MySQLi`
- **Port:** `3306`

---

## 📂 Módulos Implementados

| Módulo | Tabla | Controlador | Descripción |
|---|---|---|---|
| **Dashboard** | Todas | `Home.php` | Métricas generales, contadores de las 9 tablas y personas recientes |
| **Personas** | `persona` | `Persona.php` | CRUD completo, buscador por cédula/nombre, perfil maestro con gestión de correos, direcciones, estados civiles y géneros vinculados |
| **Clientes** | `cliente` | `Cliente.php` | Asignación y administración de personas como clientes del gimnasio |
| **Correos** | `correo` | `Correo.php` | Registro y listado de correos electrónicos con fecha de obtención |
| **Direcciones** | `direccion` | `Direccion.php` | Registro y listado de direcciones domiciliarias y de contacto |
| **Sexos** | `sexo` | `Sexo.php` | Catálogo de sexos |
| **Estados Civiles** | `estadocivil` | `EstadoCivil.php` | Catálogo de estados civiles |
| **Géneros** | `genero` | `Genero.php` | Catálogo de identidades de género |
| **Estado Civil - Persona** | `estadocivilpersona` | `EstadoCivilPersona.php` | Gestión de asignaciones entre personas y estados civiles |
| **Género - Persona** | `generopersona` | `GeneroPersona.php` | Gestión de asignaciones entre personas e identidades de género |

---

## ✨ Características Técnicas
- **CodeIgniter v4.7.4** con arquitectura MVC limpia.
- **Bootstrap 5.3 + Bootstrap Icons** para interfaz moderna y responsive.
- Validaciones completas en servidor (cédula única, correos válidos, campos requeridos).
- Transacciones de base de datos (`$db->transStart()`, `$db->transComplete()`) para operaciones compuestas.
- Alertas flash para mensajes de éxito y errores.
