#!/bin/sh
set -e

# Sync public/ assets ke shared volume agar Nginx selalu serve file terbaru.
# Ini mengatasi masalah Docker named volume yang tidak ter-update saat rebuild.
echo "[entrypoint] Syncing public assets to shared volume..."
cp -r /var/www/html/public/. /shared-public/
echo "[entrypoint] Sync complete. Starting PHP-FPM..."

exec php-fpm
