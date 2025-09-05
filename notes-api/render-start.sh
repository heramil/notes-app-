#!/usr/bin/env sh
set -eu

# Generate APP_KEY once (safe if already set by Render)
if [ -z "${APP_KEY:-}" ]; then
  php artisan key:generate --force --no-interaction
fi

# Run migrations with retries (DB may not be ready yet on first boot)
i=0
max=15
until php artisan migrate --force --no-interaction; do
  i=$((i+1))
  if [ "$i" -ge "$max" ]; then
    echo "⚠️  Migrations still failing after $max attempts; continuing startup."
    break
  fi
  echo "⏳ DB not ready yet; retrying in 5s... ($i/$max)"
  sleep 5
done

# Seeding is optional; won't fail the boot
php artisan db:seed --force --no-interaction || true

# Serve Laravel (Render provides $PORT)
php -S 0.0.0.0:${PORT:-8080} -t public
