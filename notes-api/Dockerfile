# ---- Stage 1: install PHP deps with Composer (fast, reliable) ----
FROM composer:2 AS vendor
WORKDIR /app

# Composer env hardening
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV COMPOSER_MEMORY_LIMIT=-1

# Copy only composer files first (best layer caching)
COPY composer.json composer.lock ./

# Install without dev & scripts; keep it deterministic and CI-friendly
RUN composer install \
    --no-dev \
    --prefer-dist \
    --no-interaction \
    --no-progress \
    --no-ansi \
    --no-scripts

# ---- Stage 2: runtime image (PHP 8.4 + needed extensions) ----
FROM thecodingmachine/php:8.4-v5-cli
WORKDIR /usr/src/app

# Laravel needs mbstring; many stacks need zip; we need pdo_pgsql for Postgres
ENV PHP_EXTENSIONS="mbstring zip pdo_pgsql"

# Copy app code
COPY . .

# Bring in vendor from Composer stage
COPY --from=vendor /app/vendor ./vendor

# Expose port (Render sets $PORT)
EXPOSE 8080

# Start
