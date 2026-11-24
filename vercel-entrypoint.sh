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

# Auto-migrate and seed once on PostgreSQL (Neon) using unpooled connection + advisory lock
if [ -n "${DATABASE_URL:-}" ] || [ -n "${POSTGRES_URL:-}" ] || [ "${DB_CONNECTION:-}" = "pgsql" ]; then
    MIGRATE_URL="${DATABASE_URL_UNPOOLED:-${POSTGRES_URL_NON_POOLING:-${DATABASE_URL:-${POSTGRES_URL:-}}}}"
    DATABASE_URL="${MIGRATE_URL}" POSTGRES_URL="${MIGRATE_URL}" DB_CONNECTION="pgsql" php -r '
        require "/var/www/html/vendor/autoload.php";
        $app = require "/var/www/html/bootstrap/app.php";
        $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
        $kernel->bootstrap();

        $db = Illuminate\Support\Facades\DB::connection("pgsql");
        $lockKey = 749201;
        try {
            $db->statement("SELECT pg_advisory_lock(?)", [$lockKey]);
            $hasUsers = Illuminate\Support\Facades\Schema::connection("pgsql")->hasTable("users");
            if (!$hasUsers) {
                fwrite(STDERR, "[fixhome] Initializing Neon Postgres schema & seed data...\n");
                Illuminate\Support\Facades\Artisan::call("migrate", ["--force" => true]);
                Illuminate\Support\Facades\Artisan::call("db:seed", ["--force" => true]);
                fwrite(STDERR, "[fixhome] Neon Postgres schema & seed completed.\n");
            } else {
                $userCount = (int) $db->table("users")->count();
                if ($userCount === 0) {
                    fwrite(STDERR, "[fixhome] Empty Neon database detected; running migrations & seed...\n");
                    Illuminate\Support\Facades\Artisan::call("migrate", ["--force" => true]);
                    Illuminate\Support\Facades\Artisan::call("db:seed", ["--force" => true]);
                    fwrite(STDERR, "[fixhome] Neon Postgres seed completed.\n");
                }
            }
        } catch (Throwable $e) {
            fwrite(STDERR, "[fixhome] Postgres bootstrap warning: " . $e->getMessage() . "\n");
        } finally {
            try {
                $db->statement("SELECT pg_advisory_unlock(?)", [$lockKey]);
            } catch (Throwable $ignore) {}
        }
    '
elif [ "${DB_CONNECTION:-sqlite}" = "sqlite" ]; then
    # Fallback: writable SQLite database in /tmp from pre-seeded template
    DB_FILE="${DB_DATABASE:-/tmp/database.sqlite}"
    if [ ! -f "${DB_FILE}" ] && [ -f /var/www/html/database/seed-template.sqlite ]; then
        cp /var/www/html/database/seed-template.sqlite "${DB_FILE}"
        chown www-data:www-data "${DB_FILE}"
    fi
fi

# Honor dynamic PORT if provided by platform (default 80 for Vercel Containers)
PORT_TO_USE="${PORT:-80}"
if [ "${PORT_TO_USE}" != "80" ]; then
    sed -i "s/Listen 80/Listen ${PORT_TO_USE}/g" /etc/apache2/ports.conf
    sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT_TO_USE}>/g" /etc/apache2/sites-available/000-default.conf
fi

exec apache2-foreground
