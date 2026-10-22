#!/usr/bin/env bash
# ==============================================================================
# Script: bajar_db_servidor.sh
# Descripción: Descarga un respaldo de la base de datos 'gim360' desde el servidor
#              remoto y opcionalmente actualiza la base de datos local.
# ==============================================================================

set -eo pipefail

RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
CYAN='\033[0;36m'
BOLD='\033[1m'
NC='\033[0m'

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
PROJECT_DIR="$(cd "$SCRIPT_DIR/.." && pwd)"

# Valores por defecto del servidor remoto
REMOTE_SSH_HOST="5.161.176.197"
REMOTE_SSH_USER="root"
REMOTE_SSH_PASS="PIwiIB.1234"
REMOTE_DB_NAME="gim360"
REMOTE_DB_USER="root"
REMOTE_DB_PASS="PIWIIB1234"

# Valores locales
LOCAL_DB_HOST="localhost"
LOCAL_DB_PORT="3306"
LOCAL_DB_NAME="gim360"
LOCAL_DB_USER="root"
LOCAL_DB_PASS="PIWIIB1234"

# Cargar configuración local de .env si existe
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

# Cargar variables remotas opcionales desde config_nube.env si existe
if [ -f "$SCRIPT_DIR/config_nube.env" ]; then
    # shellcheck disable=SC1091
    source "$SCRIPT_DIR/config_nube.env"
    [ -n "$CLOUD_DB_HOST" ] && REMOTE_SSH_HOST="$CLOUD_DB_HOST"
    [ -n "$CLOUD_DB_NAME" ] && REMOTE_DB_NAME="$CLOUD_DB_NAME"
    [ -n "$CLOUD_DB_USER" ] && REMOTE_DB_USER="$CLOUD_DB_USER"
    [ -n "$CLOUD_DB_PASS" ] && REMOTE_DB_PASS="$CLOUD_DB_PASS"
fi

ACTUALIZAR_LOCAL=true
FECHA_ACTUAL=$(date +%Y-%m-%d)
TIMESTAMP=$(date +%Y%m%d_%H%M%S)
OUTPUT_FILE="$SCRIPT_DIR/gim360-${FECHA_ACTUAL}.sql"

mostrar_ayuda() {
    echo -e "${BOLD}Uso:${NC} $0 [opciones]"
    echo ""
    echo "Opciones:"
    echo "  --solo-descargar    Descarga el respaldo remoto sin actualizar la BD local"
    echo "  --host HOST         IP o dominio del servidor remoto (defecto: $REMOTE_SSH_HOST)"
    echo "  --ssh-user USUARIO  Usuario SSH (defecto: $REMOTE_SSH_USER)"
    echo "  --db NOMBRE_BD      Nombre de la BD remota (defecto: $REMOTE_DB_NAME)"
    echo "  -h, --help          Muestra este mensaje"
    echo ""
}

while [[ $# -gt 0 ]]; do
    case "$1" in
        --solo-descargar)
            ACTUALIZAR_LOCAL=false
            shift
            ;;
        --host)
            REMOTE_SSH_HOST="$2"
            shift 2
            ;;
        --ssh-user)
            REMOTE_SSH_USER="$2"
            shift 2
            ;;
        --db)
            REMOTE_DB_NAME="$2"
            shift 2
            ;;
        -h|--help)
            mostrar_ayuda
            exit 0
            ;;
        *)
            echo -e "${RED}Opción desconocida: $1${NC}"
            mostrar_ayuda
            exit 1
            ;;
    esac
done

echo -e "${CYAN}${BOLD}=== BAJAR RESPALDO DE BASE DE DATOS REMOTA (GIM360) ===${NC}\n"
echo -e "Servidor SSH:  ${YELLOW}${REMOTE_SSH_USER}@${REMOTE_SSH_HOST}${NC}"
echo -e "Base Remota:   ${YELLOW}${REMOTE_DB_NAME}${NC}"
echo -e "Archivo local: ${YELLOW}${OUTPUT_FILE}${NC}"
echo -e "BD Local:      ${YELLOW}${LOCAL_DB_NAME}${NC}\n"

# 1. Verificar herramientas necesarias
if ! command -v sshpass &> /dev/null; then
    echo -e "${RED}[ERROR] 'sshpass' no está instalado localmente.${NC}"
    exit 1
fi

# 2. Descargar dump desde el servidor remoto
echo -e "${BLUE}[1/3] Descargando volcado desde el servidor remoto...${NC}"
sshpass -p "$REMOTE_SSH_PASS" ssh -o StrictHostKeyChecking=no -o ConnectTimeout=15 "${REMOTE_SSH_USER}@${REMOTE_SSH_HOST}" \
    "mariadb-dump -u ${REMOTE_DB_USER} -p'${REMOTE_DB_PASS}' --single-transaction --quick --routines --triggers ${REMOTE_DB_NAME}" > "$OUTPUT_FILE"

TAMANIO=$(stat -c%s "$OUTPUT_FILE" 2>/dev/null || stat -f%z "$OUTPUT_FILE" 2>/dev/null || echo "0")
if [ "$TAMANIO" -lt 1000 ]; then
    echo -e "${RED}[ERROR] El archivo descargado es demasiado pequeño o está vacío (${TAMANIO} bytes). Revisa los accesos.${NC}"
    cat "$OUTPUT_FILE"
    exit 1
fi

echo -e "${GREEN}[OK] Volcado descargado exitosamente (${TAMANIO} bytes).${NC}"

# 3. Sincronizar copias canónicas del proyecto
cp "$OUTPUT_FILE" "$SCRIPT_DIR/gim360.sql"
cp "$OUTPUT_FILE" "$PROJECT_DIR/gim360.sql"
echo -e "${GREEN}[OK] Actualizados: dbrespaldo/gim360.sql y gim360.sql${NC}"

# 4. Actualizar base de datos local si se solicita
if [ "$ACTUALIZAR_LOCAL" = true ]; then
    echo -e "\n${BLUE}[2/3] Creando respaldo de seguridad previo de la base local...${NC}"
    BACKUP_PREVIO="$SCRIPT_DIR/gim360_local_previo_${TIMESTAMP}.sql"
    mariadb-dump -h "$LOCAL_DB_HOST" -P "$LOCAL_DB_PORT" -u "$LOCAL_DB_USER" -p"$LOCAL_DB_PASS" "$LOCAL_DB_NAME" > "$BACKUP_PREVIO" 2>/dev/null || true
    echo -e "${GREEN}[OK] Respaldo previo local guardado en: $(basename "$BACKUP_PREVIO")${NC}"

    echo -e "\n${BLUE}[3/3] Importando volcado en la base de datos local (${LOCAL_DB_NAME})...${NC}"
    mariadb -h "$LOCAL_DB_HOST" -P "$LOCAL_DB_PORT" -u "$LOCAL_DB_USER" -p"$LOCAL_DB_PASS" -e \
        "DROP DATABASE IF EXISTS ${LOCAL_DB_NAME}; CREATE DATABASE ${LOCAL_DB_NAME} CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;"
    mariadb -h "$LOCAL_DB_HOST" -P "$LOCAL_DB_PORT" -u "$LOCAL_DB_USER" -p"$LOCAL_DB_PASS" "$LOCAL_DB_NAME" < "$OUTPUT_FILE"
    echo -e "${GREEN}[OK] Base de datos local '${LOCAL_DB_NAME}' actualizada exitosamente.${NC}"
fi

echo -e "\n${GREEN}${BOLD}¡Proceso completado con éxito!${NC}"
