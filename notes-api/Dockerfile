# Multi-stage: install PHP deps with Composer image, then run on lightweight runtime
FROM composer:2 AS vendor
WORKDIR /app

# Copy only composer files first (better caching)
COPY composer.json composer.lock ./
RUN composer install --no-dev --prefer-dist --no-interaction --no-progress

# Final runtime image
FROM thecodingmachine/php:8.4-v5-cli
WORKDIR /usr/src/app

# Enable required PHP extensions (pdo_pgsql is key for Postgres)
ENV PHP_EXTENSIONS="pdo_pgsql"

# Copy app code
COPY . .

# Copy vendor directory from the Composer stage
COPY --from=vendor /app/vendor ./vendor

# Expose port (Render sets $PORT at runtime)
EXPOSE 8080

# Start Laravel via your start script
CMD ["sh", "-lc", "./render-start.sh"]
