# notes-api/Dockerfile
FROM thecodingmachine/php:8.4-v5-cli

WORKDIR /usr/src/app

# Enable the PostgreSQL PDO extension (no apt-get needed)
ENV PHP_EXTENSIONS="pdo_pgsql"

# Copy app
COPY . .

# Install dependencies
RUN composer install --no-dev --prefer-dist --no-interaction --no-progress

# Helpful (docs only; Render doesn't rely on EXPOSE)
EXPOSE 8080

# Start script (we’ll set this in render.yaml, but leaving as default too)
CMD ["sh", "-lc", "./render-start.sh"]
