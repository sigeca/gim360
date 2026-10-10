#!/usr/bin/env bash
# ==============================================================================
# Script: subir_db_nube.sh
# Descripción: Genera respaldo optimizado de la base de datos local 'gim360' y la sube /
#              sincroniza con la base de datos en la nube (MySQL / MariaDB).
# ==============================================================================

set -eo pipefail

# Colores para salida de consola
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
CYAN='\033[0;36m'
MAGENTA='\033[0;35m'
BOLD='\033[1m'
NC='\033[0m' # Sin color

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
PROJECT_DIR="$(cd "$SCRIPT_DIR/.." && pwd)"

# Valores por defecto para base de datos local
LOCAL_DB_HOST="localhost"
LOCAL_DB_PORT="3306"
LOCAL_DB_NAME="gim360"
LOCAL_DB_USER="root"
LOCAL_DB_PASS="PIWIIB1234"

# Cargar configuración local de .env de CodeIgniter si existe
if [ -f "$PROJECT_DIR/.env" ]; then
    ENV_LOCAL_HOST=$(grep -E '^[[:space:]]*database\.default\.hostname[[:space:]]*=' "$PROJECT_DIR/.env" | awk -F'=' '{print $2}' | tr -d " '\"" | tr -d '\r')
    ENV_LOCAL_DB=$(grep -E '^[[:space:]]*database\.default\.database[[:space:]]*=' "$PROJECT_DIR/.env" | awk -F'=' '{print $2}' | tr -d " '\"" | tr -d '\r')
    ENV_LOCAL_USER=$(grep -E '^[[:space:]]*database\.default\.username[[:space:]]*=' "$PROJECT_DIR/.env" | awk -F'=' '{print $2}' | tr -d " '\"" | tr -d '\r')
    ENV_LOCAL_PASS=$(grep -E '^[[:space:]]*database\.default\.password[[:space:]]*=' "$PROJECT_DIR/.env" | awk -F'=' '{print $2}' | tr -d " '\"" | tr -d '\r')
    ENV_LOCAL_PORT=$(grep -E '^[[:space:]]*database\.default\.port[[:space:]]*=' "$PROJECT_DIR/.env" | awk -F'=' '{print $2}' | tr -d " '\"" | tr -d '\r')

    [ -n "$ENV_LOCAL_HOST" ] && LOCAL_DB_HOST="$ENV_LOCAL_HOST"
    [ -n "$ENV_LOCAL_DB" ]   && LOCAL_DB_NAME="$ENV_LOCAL_DB"
    [ -n "$ENV_LOCAL_USER" ] && LOCAL_DB_USER="$ENV_LOCAL_USER"
    [ -n "$ENV_LOCAL_PASS" ] && LOCAL_DB_PASS="$ENV_LOCAL_PASS"
    [ -n "$ENV_LOCAL_PORT" ] && LOCAL_DB_PORT="$ENV_LOCAL_PORT"
fi

# Cargar configuración de la nube desde config_nube.env si existe
CONFIG_NUBE_FILE="$SCRIPT_DIR/config_nube.env"
if [ -f "$CONFIG_NUBE_FILE" ]; then
    # shellcheck disable=SC1090
    source "$CONFIG_NUBE_FILE"
fi

# Variables de la nube (pueden ser sobreescritas por CLI)
CLOUD_DB_HOST="${CLOUD_DB_HOST:-}"
CLOUD_DB_PORT="${CLOUD_DB_PORT:-3306}"
CLOUD_DB_NAME="${CLOUD_DB_NAME:-gim360}"
CLOUD_DB_USER="${CLOUD_DB_USER:-}"
CLOUD_DB_PASS="${CLOUD_DB_PASS:-}"
CLOUD_DB_SSL="${CLOUD_DB_SSL:-false}"

SOLO_EXPORTAR=false
CREAR_DB=false
LIMPIAR_REMOTA=false
USAR_SQL_EXISTENTE=false
VERIFICAR_SOLO=false
FORCE_YES=false
CUSTOM_SQL_FILE=""

# Mostrar ayuda
mostrar_ayuda() {
    echo -e "${BOLD}Uso:${NC} $0 [OPCIONES]"
    echo ""
    echo -e "${BOLD}Opciones de conexión a la nube:${NC}"
    echo "  -h, --host HOST        Host o IP del servidor MySQL remoto"
    echo "  -P, --port PUERTO      Puerto remoto (por defecto: 3306)"
    echo "  -u, --user USUARIO     Usuario de MySQL remoto"
    echo "  -p, --pass PASSWORD    Contraseña de MySQL remoto"
    echo "  -d, --db NOMBRE_BD     Nombre de la base de datos remota (por defecto: gim360)"
    echo "      --ssl              Habilitar conexión con SSL (--ssl-mode=REQUIRED)"
    echo "      --crear-db         Intentar ejecutar 'CREATE DATABASE IF NOT EXISTS' en la nube"
    echo "      --limpiar, --reset Eliminar tablas y vistas existentes en la nube antes de importar"
    echo "      --verificar        Probar conexión remota e inspeccionar tablas actuales sin modificar"
    echo ""
    echo -e "${BOLD}Opciones de origen y exportación:${NC}"
    echo "  -f, --file ARCHIVO     Usar un archivo .sql específico en lugar de exportar la BD local"
    echo "      --usar-sql         Usar directamente el archivo 'gim360.sql' del proyecto (sin volcar)"
    echo "      --solo-exportar    Generar solo el respaldo local limpio y actualizar copias sin subir"
    echo "  -y, --yes, --force     Omitir confirmaciones interactivas"
    echo "      --help             Mostrar esta ayuda"
    echo ""
    echo -e "${BOLD}Nota:${NC} Puedes guardar tus credenciales de la nube en ${CYAN}$SCRIPT_DIR/config_nube.env${NC}"
    echo "para no tener que escribirlas cada vez."
    exit 0
}

# Parsear argumentos de línea de comando
while [[ $# -gt 0 ]]; do
    case "$1" in
        -h|--host)
            CLOUD_DB_HOST="$2"
            shift 2
            ;;
        -P|--port)
            CLOUD_DB_PORT="$2"
            shift 2
            ;;
        -u|--user)
            CLOUD_DB_USER="$2"
            shift 2
            ;;
        -p|--pass)
            CLOUD_DB_PASS="$2"
            shift 2
            ;;
        -d|--db)
            CLOUD_DB_NAME="$2"
            shift 2
            ;;
        --ssl)
            CLOUD_DB_SSL="true"
            shift
            ;;
        --crear-db)
            CREAR_DB="true"
            shift
            ;;
        --limpiar|--reset)
            LIMPIAR_REMOTA="true"
            shift
            ;;
        --verificar|--check)
            VERIFICAR_SOLO="true"
            shift
            ;;
        -f|--file)
            CUSTOM_SQL_FILE="$2"
            shift 2
            ;;
        --usar-sql)
            USAR_SQL_EXISTENTE="true"
            shift
            ;;
        --solo-exportar)
            SOLO_EXPORTAR="true"
            shift
            ;;
        -y|--yes|--force)
            FORCE_YES="true"
            shift
            ;;
        --help)
            mostrar_ayuda
            ;;
        *)
            echo -e "${RED}[ERROR] Opción desconocida: $1${NC}"
            echo "Usa '$0 --help' para ver las opciones disponibles."
            exit 1
            ;;
    esac
done

echo -e "${CYAN}======================================================================${NC}"
echo -e "${BOLD}${CYAN}   Sincronización / Respaldo de Base de Datos GIM360 a la Nube   ${NC}"
echo -e "${CYAN}======================================================================${NC}"

# Detectar binario mysqldump / mariadb-dump
DUMP_BIN=""
if command -v mysqldump &> /dev/null; then
    DUMP_BIN="mysqldump"
elif command -v mariadb-dump &> /dev/null; then
    DUMP_BIN="mariadb-dump"
fi

# Detectar cliente mysql / mariadb
MYSQL_BIN=""
if command -v mysql &> /dev/null; then
    MYSQL_BIN="mysql"
elif command -v mariadb &> /dev/null; then
    MYSQL_BIN="mariadb"
else
    echo -e "${RED}[ERROR] No se encontró el cliente 'mysql' ni 'mariadb'.${NC}"
    exit 1
fi

# Función para sanitizar archivos SQL para máxima compatibilidad con la nube
sanitizar_sql() {
    local target_file="$1"
    echo -e "${BLUE}[INFO]${NC} Optimizando compatibilidad cloud (eliminando DEFINER, sandbox y normalizando charsets)..."

    # 1. Eliminar sandbox de MariaDB
    sed -i '/\/\*M!999999\\- enable the sandbox mode \*\//d' "$target_file" 2>/dev/null || true

    # 2. Eliminar bloques de DEFINER y SQL SECURITY DEFINER en vistas (/*!50013 DEFINER=... SQL SECURITY DEFINER */)
    sed -i -E 's/\/\*!50013[[:space:]]+DEFINER=[^*]+\*\///g' "$target_file" 2>/dev/null || true
    sed -i -E 's/\/\*!50013[[:space:]]+SQL SECURITY DEFINER[[:space:]]*\*\///g' "$target_file" 2>/dev/null || true

    # 3. Eliminar cláusulas DEFINER residuales en triggers, funciones o procedimientos
    sed -i -E 's/DEFINER=`[^`]+`@`[^`]+`//g' "$target_file" 2>/dev/null || true
    sed -i -E 's/DEFINER=[^ ]+//g' "$target_file" 2>/dev/null || true

    # 4. Eliminar bloqueos de tablas
    sed -i -E '/LOCK TABLES `[^`]+` WRITE;/d' "$target_file" 2>/dev/null || true
    sed -i -E '/UNLOCK TABLES;/d' "$target_file" 2>/dev/null || true

    # 5. Normalizar utf8mb3 -> utf8mb4 para evitar avisos de obsolescencia en MySQL 8
    sed -i 's/utf8mb3_general_ci/utf8mb4_spanish_ci/g' "$target_file" 2>/dev/null || true
    sed -i 's/utf8mb3/utf8mb4/g' "$target_file" 2>/dev/null || true
}

# PASO 1: Generar o seleccionar el archivo SQL
TIMESTAMP=$(date +"%Y-%m-%d_%H%M%S")
FECHA_DIA=$(date +"%Y-%m-%d")
BACKUP_FILE=""

if [ "$VERIFICAR_SOLO" = "false" ]; then
    if [ -n "$CUSTOM_SQL_FILE" ]; then
        if [ ! -f "$CUSTOM_SQL_FILE" ]; then
            echo -e "${RED}[ERROR] El archivo especificado no existe: $CUSTOM_SQL_FILE${NC}"
            exit 1
        fi
        BACKUP_FILE="$CUSTOM_SQL_FILE"
        echo -e "${BLUE}[INFO]${NC} Usando archivo SQL personalizado: ${BOLD}$BACKUP_FILE${NC}"
    elif [ "$USAR_SQL_EXISTENTE" = "true" ]; then
        if [ -f "$PROJECT_DIR/gim360.sql" ]; then
            BACKUP_FILE="$PROJECT_DIR/gim360.sql"
        elif [ -f "$SCRIPT_DIR/gim360.sql" ]; then
            BACKUP_FILE="$SCRIPT_DIR/gim360.sql"
        else
            echo -e "${RED}[ERROR] No se encontró el archivo gim360.sql para usar.${NC}"
            exit 1
        fi
        echo -e "${BLUE}[INFO]${NC} Usando archivo SQL canonical existente: ${BOLD}$BACKUP_FILE${NC}"
    else
        echo -e "${BLUE}[1/4]${NC} Verificando conexión a la base de datos local (${BOLD}$LOCAL_DB_NAME${NC} en ${LOCAL_DB_HOST}:${LOCAL_DB_PORT})..."

        # Probar conexión local de manera segura con MYSQL_PWD
        CONEXION_LOCAL_OK=true
        MYSQL_LOCAL_ARGS=(-h "$LOCAL_DB_HOST" -P "$LOCAL_DB_PORT" -u "$LOCAL_DB_USER")
        if ! MYSQL_PWD="$LOCAL_DB_PASS" "$MYSQL_BIN" "${MYSQL_LOCAL_ARGS[@]}" -e "USE \`$LOCAL_DB_NAME\`;" 2>/dev/null; then
            CONEXION_LOCAL_OK=false
        fi

        if [ "$CONEXION_LOCAL_OK" = "true" ] && [ -n "$DUMP_BIN" ]; then
            echo -e "${GREEN}[OK]${NC} Conexión local exitosa."

            BACKUP_FILE="$SCRIPT_DIR/gim360_${TIMESTAMP}.sql"
            echo -e "${BLUE}[2/4]${NC} Exportando base de datos local con ${DUMP_BIN}..."

            DUMP_LOCAL_ARGS=(-h "$LOCAL_DB_HOST" -P "$LOCAL_DB_PORT" -u "$LOCAL_DB_USER")
            MYSQL_PWD="$LOCAL_DB_PASS" "$DUMP_BIN" "${DUMP_LOCAL_ARGS[@]}" \
                --single-transaction \
                --skip-add-locks \
                --quick \
                --routines \
                --triggers \
                --hex-blob \
                --default-character-set=utf8mb4 \
                "$LOCAL_DB_NAME" > "$BACKUP_FILE"

            sanitizar_sql "$BACKUP_FILE"

            if [ ! -s "$BACKUP_FILE" ]; then
                echo -e "${RED}[ERROR] El respaldo generado está vacío.${NC}"
                rm -f "$BACKUP_FILE"
                exit 1
            fi

            TAMANO_HUMANO=$(du -h "$BACKUP_FILE" | cut -f1)
            echo -e "${GREEN}[OK]${NC} Respaldo generado y optimizado: ${BOLD}$BACKUP_FILE${NC} (${TAMANO_HUMANO})"

            # Actualizar copias sincronizadas en dbrespaldo y raíz
            cp "$BACKUP_FILE" "$SCRIPT_DIR/gim360-${FECHA_DIA}.sql"
            cp "$BACKUP_FILE" "$SCRIPT_DIR/gim360.sql"
            cp "$BACKUP_FILE" "$PROJECT_DIR/gim360.sql"
            echo -e "${GREEN}[OK]${NC} Copias sincronizadas: ${BOLD}dbrespaldo/gim360-${FECHA_DIA}.sql${NC} y ${BOLD}gim360.sql${NC}"
        else
            echo -e "${YELLOW}[AVISO] No se pudo conectar a la base local o falta comando dump.${NC}"
            if [ -f "$PROJECT_DIR/gim360.sql" ]; then
                BACKUP_FILE="$PROJECT_DIR/gim360.sql"
                echo -e "${BLUE}[INFO]${NC} Se utilizará automáticamente el archivo existente: ${BOLD}$BACKUP_FILE${NC}"
            elif [ -f "$SCRIPT_DIR/gim360.sql" ]; then
                BACKUP_FILE="$SCRIPT_DIR/gim360.sql"
                echo -e "${BLUE}[INFO]${NC} Se utilizará automáticamente el archivo existente: ${BOLD}$BACKUP_FILE${NC}"
            else
                echo -e "${RED}[ERROR] No se pudo generar el respaldo ni se encontró gim360.sql.${NC}"
                exit 1
            fi
        fi
    fi
fi

# Si solo se solicitó exportar, finalizamos con éxito
if [ "$SOLO_EXPORTAR" = "true" ]; then
    echo -e "\n${GREEN}${BOLD}[ÉXITO] Respaldo local generado y copias sincronizadas correctamente.${NC}"
    exit 0
fi

# PASO 2: Verificar credenciales de la nube
if [ -z "$CLOUD_DB_HOST" ] || [ -z "$CLOUD_DB_USER" ] || [ -z "$CLOUD_DB_PASS" ]; then
    if [ -t 0 ]; then
        echo -e "\n${YELLOW}[!] Faltan credenciales de la base de datos en la nube.${NC}"
        echo "Por favor ingrésalas a continuación:"
        echo ""
        read -rp "Host / IP en la nube: " INPUT_HOST
        read -rp "Puerto en la nube [3306]: " INPUT_PORT
        read -rp "Nombre de BD en la nube [gim360]: " INPUT_DB
        read -rp "Usuario en la nube: " INPUT_USER
        read -rsp "Contraseña en la nube: " INPUT_PASS
        echo ""

        [ -n "$INPUT_HOST" ] && CLOUD_DB_HOST="$INPUT_HOST"
        [ -n "$INPUT_PORT" ] && CLOUD_DB_PORT="$INPUT_PORT"
        [ -n "$INPUT_DB" ]   && CLOUD_DB_NAME="$INPUT_DB"
        [ -n "$INPUT_USER" ] && CLOUD_DB_USER="$INPUT_USER"
        [ -n "$INPUT_PASS" ] && CLOUD_DB_PASS="$INPUT_PASS"

        read -rp "¿Deseas guardar estas credenciales en 'config_nube.env' para futuras ocasiones? (s/n): " GUARDAR_CONF
        if [[ "$GUARDAR_CONF" =~ ^[sSyY]$ ]]; then
            cat <<EOF > "$CONFIG_NUBE_FILE"
# Configuración de base de datos en la nube (Generada el $(date))
CLOUD_DB_HOST="$CLOUD_DB_HOST"
CLOUD_DB_PORT="$CLOUD_DB_PORT"
CLOUD_DB_NAME="$CLOUD_DB_NAME"
CLOUD_DB_USER="$CLOUD_DB_USER"
CLOUD_DB_PASS="$CLOUD_DB_PASS"
CLOUD_DB_SSL="$CLOUD_DB_SSL"
EOF
            chmod 600 "$CONFIG_NUBE_FILE"
            echo -e "${GREEN}[OK]${NC} Credenciales guardadas en ${CYAN}$CONFIG_NUBE_FILE${NC} (ignorado en git)."
        fi
    fi
fi

if [ -z "$CLOUD_DB_HOST" ] || [ -z "$CLOUD_DB_USER" ] || [ -z "$CLOUD_DB_PASS" ]; then
    echo -e "\n${YELLOW}----------------------------------------------------------------------${NC}"
    echo -e "${YELLOW}[AVISO] El respaldo local está listo, pero faltan credenciales de la nube:${NC}"
    echo -e "Configura tus credenciales creando el archivo:"
    echo -e "  ${BOLD}cp $SCRIPT_DIR/config_nube.env.example $CONFIG_NUBE_FILE${NC}"
    echo -e "y edita los valores con tu host, usuario y contraseña remotos."
    echo ""
    echo -e "O ejecuta directamente:"
    echo -e "  ${CYAN}$0 -h <HOST_NUBE> -u <USUARIO_NUBE> -p <PASSWORD_NUBE> -d <BD_NUBE>${NC}"
    echo -e "${YELLOW}----------------------------------------------------------------------${NC}"
    exit 0
fi

# Configuración de opciones para cliente MySQL remoto
MYSQL_CLOUD_OPTS=(-h "$CLOUD_DB_HOST" -P "$CLOUD_DB_PORT" -u "$CLOUD_DB_USER")
if [ "$CLOUD_DB_SSL" = "true" ]; then
    MYSQL_CLOUD_OPTS+=(--ssl-mode=REQUIRED)
fi

# PASO 3: Probar conexión con la base de datos en la nube
echo -e "${BLUE}[3/4]${NC} Probando conexión con el servidor MySQL en la nube (${BOLD}$CLOUD_DB_HOST:$CLOUD_DB_PORT${NC})..."

if ! MYSQL_PWD="$CLOUD_DB_PASS" "$MYSQL_BIN" "${MYSQL_CLOUD_OPTS[@]}" -e "SELECT 1;" &> /dev/null; then
    echo -e "${RED}[ERROR] No se pudo conectar al servidor MySQL en la nube ($CLOUD_DB_HOST:$CLOUD_DB_PORT).${NC}"
    echo "Verifica que el host, puerto, usuario y contraseña sean correctos y que el firewall/proveedor permita conexiones externas."
    exit 1
fi
echo -e "${GREEN}[OK]${NC} Conexión con el servidor remoto exitosa."

# Crear la base de datos si se solicitó
if [ "$CREAR_DB" = "true" ]; then
    echo -e "${BLUE}[INFO]${NC} Asegurando que la base de datos '${CLOUD_DB_NAME}' exista en la nube..."
    MYSQL_PWD="$CLOUD_DB_PASS" "$MYSQL_BIN" "${MYSQL_CLOUD_OPTS[@]}" \
        -e "CREATE DATABASE IF NOT EXISTS \`$CLOUD_DB_NAME\` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;" 2>/dev/null || true
fi

# Verificar si la base de datos existe
if ! MYSQL_PWD="$CLOUD_DB_PASS" "$MYSQL_BIN" "${MYSQL_CLOUD_OPTS[@]}" -e "USE \`$CLOUD_DB_NAME\`;" &> /dev/null; then
    echo -e "${YELLOW}[!] La base de datos '$CLOUD_DB_NAME' no parece existir en la nube.${NC}"
    echo -e "${BLUE}[INFO]${NC} Intentando crear la base de datos '$CLOUD_DB_NAME'..."
    if ! MYSQL_PWD="$CLOUD_DB_PASS" "$MYSQL_BIN" "${MYSQL_CLOUD_OPTS[@]}" -e "CREATE DATABASE IF NOT EXISTS \`$CLOUD_DB_NAME\` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"; then
        echo -e "${RED}[ERROR] No se pudo seleccionar ni crear la base de datos '$CLOUD_DB_NAME'.${NC}"
        echo "Asegúrate de haber creado la base de datos previamente en el panel de control (cPanel, RDS, etc.)."
        exit 1
    fi
fi

# Conteo de tablas previas en el destino
TABLAS_PREVIAS=$(MYSQL_PWD="$CLOUD_DB_PASS" "$MYSQL_BIN" "${MYSQL_CLOUD_OPTS[@]}" "$CLOUD_DB_NAME" -N -e "SELECT COUNT(*) FROM information_schema.tables WHERE table_schema='$CLOUD_DB_NAME';" 2>/dev/null || echo "0")
echo -e "${BLUE}[INFO]${NC} Tablas y vistas actualmente en la base remota '${CLOUD_DB_NAME}': ${BOLD}${TABLAS_PREVIAS}${NC}"

# Modo de solo verificación
if [ "$VERIFICAR_SOLO" = "true" ]; then
    echo -e "\n${GREEN}[OK] Verificación completada con éxito. Servidor y base de datos remotos listos.${NC}"
    exit 0
fi

# Confirmación interactiva si hay tablas previas y no se pasó -y/--yes
if [ "$FORCE_YES" = "false" ] && [ -t 0 ]; then
    echo -e "\n${YELLOW}ATENCIÓN:${NC} Se va a actualizar la base de datos remota '${BOLD}${CLOUD_DB_NAME}${NC}' en ${BOLD}${CLOUD_DB_HOST}${NC}."
    if [ "$LIMPIAR_REMOTA" = "true" ]; then
        echo -e "${RED}Opción --limpiar activa:${NC} Se eliminarán todas las tablas y vistas existentes antes de importar."
    fi
    read -rp "¿Deseas continuar con la actualización? (s/n): " CONFIRMAR_SUBIDA
    if [[ ! "$CONFIRMAR_SUBIDA" =~ ^[sSyY]$ ]]; then
        echo -e "${YELLOW}[AVISO] Operación cancelada por el usuario.${NC}"
        exit 0
    fi
fi

# Limpiar base de datos remota si se solicitó --limpiar / --reset
if [ "$LIMPIAR_REMOTA" = "true" ]; then
    echo -e "${BLUE}[INFO]${NC} Limpiando tablas y vistas previas en la base remota..."
    SQL_DROP=$(MYSQL_PWD="$CLOUD_DB_PASS" "$MYSQL_BIN" "${MYSQL_CLOUD_OPTS[@]}" "$CLOUD_DB_NAME" -N -e "
        SELECT CONCAT('DROP TABLE IF EXISTS \`', table_name, '\`;') 
        FROM information_schema.tables 
        WHERE table_schema = '$CLOUD_DB_NAME' AND table_type = 'BASE TABLE';
        SELECT CONCAT('DROP VIEW IF EXISTS \`', table_name, '\`;') 
        FROM information_schema.tables 
        WHERE table_schema = '$CLOUD_DB_NAME' AND table_type = 'VIEW';
    " 2>/dev/null || true)

    if [ -n "$SQL_DROP" ]; then
        MYSQL_PWD="$CLOUD_DB_PASS" "$MYSQL_BIN" "${MYSQL_CLOUD_OPTS[@]}" "$CLOUD_DB_NAME" \
            -e "SET FOREIGN_KEY_CHECKS = 0; $SQL_DROP SET FOREIGN_KEY_CHECKS = 1;" 2>/dev/null || true
        echo -e "${GREEN}[OK]${NC} Tablas y vistas previas eliminadas exitosamente."
    fi
fi

# PASO 4: Importar el respaldo en la nube
echo -e "${BLUE}[4/4]${NC} Subiendo e importando respaldo en la nube (${BOLD}$CLOUD_DB_NAME${NC})..."
START_TIME=$(date +%s)

MYSQL_PWD="$CLOUD_DB_PASS" "$MYSQL_BIN" "${MYSQL_CLOUD_OPTS[@]}" \
    --default-character-set=utf8mb4 \
    --max-allowed-packet=64M \
    --binary-mode \
    --init-command="SET SESSION FOREIGN_KEY_CHECKS=0; SET SESSION UNIQUE_CHECKS=0; SET SESSION SQL_MODE='NO_AUTO_VALUE_ON_ZERO';" \
    "$CLOUD_DB_NAME" < "$BACKUP_FILE"

END_TIME=$(date +%s)
DURATION=$((END_TIME - START_TIME))

# Conteo y verificación de tablas migradas
TOTAL_TABLAS=$(MYSQL_PWD="$CLOUD_DB_PASS" "$MYSQL_BIN" "${MYSQL_CLOUD_OPTS[@]}" "$CLOUD_DB_NAME" -N -e "SELECT COUNT(*) FROM information_schema.tables WHERE table_schema='$CLOUD_DB_NAME';" 2>/dev/null || echo "N/A")

# Verificar tablas clave recientes
TABLAS_CLAVE_OK=$(MYSQL_PWD="$CLOUD_DB_PASS" "$MYSQL_BIN" "${MYSQL_CLOUD_OPTS[@]}" "$CLOUD_DB_NAME" -N -e "
    SELECT COUNT(*) FROM information_schema.tables 
    WHERE table_schema='$CLOUD_DB_NAME' 
      AND table_name IN ('rutinaprograma', 'rutinaejecicio', 'programaentrenamiento', 'planejercicio', 'programacliente', 'ejercicioequipo');
" 2>/dev/null || echo "0")

echo -e "\n${CYAN}======================================================================${NC}"
echo -e "${GREEN}${BOLD}   ✓ ¡BASE DE DATOS ACTUALIZADA EXITOSAMENTE EN LA NUBE!   ${NC}"
echo -e "${CYAN}======================================================================${NC}"
echo -e "  ${BOLD}Archivo SQL Origen:${NC}   $BACKUP_FILE"
echo -e "  ${BOLD}Destino en Nube:${NC}      $CLOUD_DB_HOST:$CLOUD_DB_PORT"
echo -e "  ${BOLD}Base Remota:${NC}          $CLOUD_DB_NAME"
echo -e "  ${BOLD}Tablas en Remoto:${NC}     $TOTAL_TABLAS"
echo -e "  ${BOLD}Tablas clave listas:${NC}  $TABLAS_CLAVE_OK / 6"
echo -e "  ${BOLD}Tiempo de subida:${NC}     ${DURATION} segundos"
echo -e "${CYAN}======================================================================${NC}"
