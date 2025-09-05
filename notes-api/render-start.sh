#!/usr/bin/env bash

set -euo pipefail

if [ -z "${APP_KEY:-}" ]; then
  php artisan key:generate --force --no-interaction
fi

php artisan migrate --force --no-interaction || true
php artisan db:seed --force --no-interaction || true

php -S 0.0.0.0:${PORT:-8080} -t public
