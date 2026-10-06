#!/usr/bin/env bash
# ==============================================================================
# Script: subir_db_nube.sh
# Descripción: Genera respaldo de la base de datos local 'gim360' y la sube
#              a la base de datos en la nube (MySQL/MariaDB).
# ==============================================================================

set -eo pipefail

# Colores para salida de consola
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
CYAN='\033[0;36m'
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
CUSTOM_SQL_FILE=""

# Mostrar ayuda
mostrar_ayuda() {
    echo -e "${BOLD}Uso:${NC} $0 [OPCIONES]"
    echo ""
    echo -e "${BOLD}Opciones de conexión a la nube:${NC}"
    echo "  -h, --host HOST       Host o IP del servidor MySQL remoto"
    echo "  -P, --port PUERTO     Puerto remoto (por defecto: 3306)"
    echo "  -u, --user USUARIO    Usuario de MySQL remoto"
    echo "  -p, --pass PASSWORD   Contraseña de MySQL remoto"
    echo "  -d, --db NOMBRE_BD    Nombre de la base de datos remota (por defecto: gim360)"
    echo "      --ssl             Habilitar conexión con SSL"
    echo "      --crear-db        Intentar ejecutar 'CREATE DATABASE IF NOT EXISTS' en la nube"
    echo ""
    echo -e "${BOLD}Opciones generales:${NC}"
    echo "  -f, --file ARCHIVO    Usar un archivo .sql existente en vez de generar uno nuevo"
    echo "      --solo-exportar   Generar solo el respaldo local sin subirlo a la nube"
    echo "      --help            Mostrar esta ayuda"
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
        -f|--file)
            CUSTOM_SQL_FILE="$2"
            shift 2
            ;;
        --solo-exportar)
            SOLO_EXPORTAR="true"
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
else
    echo -e "${RED}[ERROR] No se encontró el comando 'mysqldump' ni 'mariadb-dump'.${NC}"
    exit 1
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

# PASO 1: Generar o seleccionar el archivo SQL
TIMESTAMP=$(date +"%Y-%m-%d_%H%M%S")
BACKUP_FILE=""

if [ -n "$CUSTOM_SQL_FILE" ]; then
    if [ ! -f "$CUSTOM_SQL_FILE" ]; then
        echo -e "${RED}[ERROR] El archivo especificado no existe: $CUSTOM_SQL_FILE${NC}"
        exit 1
    fi
    BACKUP_FILE="$CUSTOM_SQL_FILE"
    echo -e "${BLUE}[INFO]${NC} Usando archivo SQL existente: ${BOLD}$BACKUP_FILE${NC}"
else
    echo -e "${BLUE}[1/4]${NC} Verificando conexión a la base de datos local (${BOLD}$LOCAL_DB_NAME${NC})..."

    # Probar conexión local
    MYSQL_LOCAL_AUTH=(-h "$LOCAL_DB_HOST" -P "$LOCAL_DB_PORT" -u "$LOCAL_DB_USER")
    if [ -n "$LOCAL_DB_PASS" ]; then
        MYSQL_LOCAL_AUTH+=("-p$LOCAL_DB_PASS")
    fi

    if ! "$MYSQL_BIN" "${MYSQL_LOCAL_AUTH[@]}" -e "USE \`$LOCAL_DB_NAME\`;" 2>/dev/null; then
        echo -e "${RED}[ERROR] No se pudo conectar a la base de datos local '$LOCAL_DB_NAME'.${NC}"
        echo "Verifica que el servicio MySQL esté corriendo y las credenciales en .env sean correctas."
        exit 1
    fi
    echo -e "${GREEN}[OK]${NC} Conexión local exitosa."

    BACKUP_FILE="$SCRIPT_DIR/gim360_${TIMESTAMP}.sql"
    echo -e "${BLUE}[2/4]${NC} Exportando base de datos local con ${DUMP_BIN}..."

    # Opciones de volcado
    DUMP_LOCAL_AUTH=(-h "$LOCAL_DB_HOST" -P "$LOCAL_DB_PORT" -u "$LOCAL_DB_USER")
    if [ -n "$LOCAL_DB_PASS" ]; then
        DUMP_LOCAL_AUTH+=("-p$LOCAL_DB_PASS")
    fi

    "$DUMP_BIN" "${DUMP_LOCAL_AUTH[@]}" \
        --single-transaction \
        --quick \
        --routines \
        --triggers \
        --hex-blob \
        --default-character-set=utf8mb4 \
        "$LOCAL_DB_NAME" > "$BACKUP_FILE"

    if [ ! -s "$BACKUP_FILE" ]; then
        echo -e "${RED}[ERROR] El respaldo generado está vacío.${NC}"
        rm -f "$BACKUP_FILE"
        exit 1
    fi

    TAMANO_HUMANO=$(du -h "$BACKUP_FILE" | cut -f1)
    echo -e "${GREEN}[OK]${NC} Respaldo generado correctamente: ${BOLD}$BACKUP_FILE${NC} (${TAMANO_HUMANO})"

    # Actualizar copias en dbrespaldo y en la raíz
    FECHA_DIA=$(date +"%Y-%m-%d")
    cp "$BACKUP_FILE" "$SCRIPT_DIR/gim360-${FECHA_DIA}.sql"
    cp "$BACKUP_FILE" "$SCRIPT_DIR/gim360.sql"
    cp "$BACKUP_FILE" "$PROJECT_DIR/gim360.sql"
    echo -e "${GREEN}[OK]${NC} Copias actualizadas: ${BOLD}dbrespaldo/gim360-${FECHA_DIA}.sql${NC} y ${BOLD}gim360.sql${NC}"
fi

# Si solo se solicitó exportar, finalizamos con éxito
if [ "$SOLO_EXPORTAR" = "true" ]; then
    echo -e "\n${GREEN}[ÉXITO] Modo solo-exportar completado con éxito.${NC}"
    exit 0
fi

# PASO 2: Verificar credenciales de la nube
if [ -z "$CLOUD_DB_HOST" ] || [ -z "$CLOUD_DB_USER" ] || [ -z "$CLOUD_DB_PASS" ]; then
    # Si la sesión es interactiva, solicitar datos por teclado
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
# Configuración guardada el $(date)
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

# Validar que ahora sí tengamos las credenciales
if [ -z "$CLOUD_DB_HOST" ] || [ -z "$CLOUD_DB_USER" ] || [ -z "$CLOUD_DB_PASS" ]; then
    echo -e "\n${YELLOW}----------------------------------------------------------------------${NC}"
    echo -e "${YELLOW}[AVISO] El respaldo local se completó correctamente, pero para subirlo a la nube:${NC}"
    echo -e "Configura tus credenciales creando el archivo:"
    echo -e "  ${BOLD}cp $SCRIPT_DIR/config_nube.env.example $CONFIG_NUBE_FILE${NC}"
    echo -e "y edita los valores con tu servidor, usuario y contraseña remotos."
    echo ""
    echo -e "O puedes ejecutar directamente:"
    echo -e "  ${CYAN}$0 -h <HOST_NUBE> -u <USUARIO_NUBE> -p <PASSWORD_NUBE> -d <BD_NUBE>${NC}"
    echo -e "${YELLOW}----------------------------------------------------------------------${NC}"
    exit 0
fi

# PASO 3: Probar conexión con la base de datos en la nube
echo -e "${BLUE}[3/4]${NC} Probando conexión con el servidor MySQL en la nube (${BOLD}$CLOUD_DB_HOST:$CLOUD_DB_PORT${NC})..."

MYSQL_CLOUD_OPTS=(-h "$CLOUD_DB_HOST" -P "$CLOUD_DB_PORT" -u "$CLOUD_DB_USER" "-p$CLOUD_DB_PASS")
if [ "$CLOUD_DB_SSL" = "true" ]; then
    MYSQL_CLOUD_OPTS+=(--ssl-mode=REQUIRED)
fi

# Test de conexión general
if ! "$MYSQL_BIN" "${MYSQL_CLOUD_OPTS[@]}" -e "SELECT 1;" &> /dev/null; then
    echo -e "${RED}[ERROR] No se pudo conectar al servidor MySQL en la nube ($CLOUD_DB_HOST:$CLOUD_DB_PORT).${NC}"
    echo "Verifica que el host, puerto, usuario y contraseña sean correctos y que el firewall permita la conexión externa."
    exit 1
fi
echo -e "${GREEN}[OK]${NC} Conexión con el servidor remoto exitosa."

# Verificar o crear la base de datos de destino
if [ "$CREAR_DB" = "true" ]; then
    echo -e "${BLUE}[INFO]${NC} Asegurando que la base de datos '${CLOUD_DB_NAME}' exista en la nube..."
    "$MYSQL_BIN" "${MYSQL_CLOUD_OPTS[@]}" -e "CREATE DATABASE IF NOT EXISTS \`$CLOUD_DB_NAME\` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;" 2>/dev/null || true
fi

# Verificar si la base de datos existe
if ! "$MYSQL_BIN" "${MYSQL_CLOUD_OPTS[@]}" -e "USE \`$CLOUD_DB_NAME\`;" &> /dev/null; then
    echo -e "${YELLOW}[!] La base de datos '$CLOUD_DB_NAME' no parece existir en la nube.${NC}"
    echo -e "${BLUE}[INFO]${NC} Intentando crear la base de datos '$CLOUD_DB_NAME'..."
    if ! "$MYSQL_BIN" "${MYSQL_CLOUD_OPTS[@]}" -e "CREATE DATABASE IF NOT EXISTS \`$CLOUD_DB_NAME\` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"; then
        echo -e "${RED}[ERROR] No se pudo seleccionar ni crear la base de datos '$CLOUD_DB_NAME'.${NC}"
        echo "Asegúrate de haber creado la base de datos previamente en el panel de control (cPanel, RDS, etc.)."
        exit 1
    fi
fi

# PASO 4: Importar el respaldo en la nube
echo -e "${BLUE}[4/4]${NC} Subiendo respaldo a la nube (${BOLD}$CLOUD_DB_NAME${NC})..."
START_TIME=$(date +%s)

"$MYSQL_BIN" "${MYSQL_CLOUD_OPTS[@]}" "$CLOUD_DB_NAME" < "$BACKUP_FILE"

END_TIME=$(date +%s)
DURATION=$((END_TIME - START_TIME))

# Conteo de tablas subidas
TOTAL_TABLAS=$("$MYSQL_BIN" "${MYSQL_CLOUD_OPTS[@]}" "$CLOUD_DB_NAME" -N -e "SELECT COUNT(*) FROM information_schema.tables WHERE table_schema='$CLOUD_DB_NAME';" 2>/dev/null || echo "N/A")

echo -e "\n${CYAN}======================================================================${NC}"
echo -e "${GREEN}${BOLD}   ✓ ¡BASE DE DATOS SUBIDA EXITOSAMENTE A LA NUBE!   ${NC}"
echo -e "${CYAN}======================================================================${NC}"
echo -e "  ${BOLD}Base Local:${NC}           $LOCAL_DB_NAME ($LOCAL_DB_HOST)"
echo -e "  ${BOLD}Archivo SQL:${NC}          $BACKUP_FILE"
echo -e "  ${BOLD}Destino en Nube:${NC}      $CLOUD_DB_HOST:$CLOUD_DB_PORT"
echo -e "  ${BOLD}Base Remota:${NC}          $CLOUD_DB_NAME"
echo -e "  ${BOLD}Tablas en Remoto:${NC}     $TOTAL_TABLAS"
echo -e "  ${BOLD}Tiempo de subida:${NC}     ${DURATION} segundos"
echo -e "${CYAN}======================================================================${NC}"
