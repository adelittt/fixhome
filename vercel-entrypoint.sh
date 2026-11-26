#!/usr/bin/env bash
set -euo pipefail

# Ensure writable ephemeral storage under /tmp for serverless/stateless containers
STORAGE_DIR="${APP_STORAGE_PATH:-/tmp/storage}"
mkdir -p \
    "${STORAGE_DIR}/app/public" \
    "${STORAGE_DIR}/framework/cache/data" \
    "${STORAGE_DIR}/framework/sessions" \
    "${STORAGE_DIR}/framework/views" \
    "${STORAGE_DIR}/logs"
chown -R www-data:www-data "${STORAGE_DIR}"

# Fallback only: prepare writable SQLite database in /tmp when no Postgres URL is configured
if [ -z "${DATABASE_URL:-}" ] && [ -z "${POSTGRES_URL:-}" ] && [ "${DB_CONNECTION:-sqlite}" = "sqlite" ]; then
    DB_FILE="${DB_DATABASE:-/tmp/database.sqlite}"
    if [ ! -f "${DB_FILE}" ] && [ -f /var/www/html/database/seed-template.sqlite ]; then
        cp /var/www/html/database/seed-template.sqlite "${DB_FILE}"
        chown www-data:www-data "${DB_FILE}"
    fi
else
    # Ensure schema migrations and idempotent 10-technician catalog are synced on live Postgres
    php /var/www/html/artisan migrate --force || true
    php /var/www/html/artisan db:seed --class=TeknisiCatalogSeeder --force || true
fi

# Honor dynamic PORT if provided by platform (default 80 for Vercel Containers)
PORT_TO_USE="${PORT:-80}"
if [ "${PORT_TO_USE}" != "80" ]; then
    sed -i "s/Listen 80/Listen ${PORT_TO_USE}/g" /etc/apache2/ports.conf
    sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT_TO_USE}>/g" /etc/apache2/sites-available/000-default.conf
fi

exec apache2-foreground
