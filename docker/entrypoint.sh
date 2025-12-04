#!/bin/bash
set -e

echo "🚀 Starting SOOQLINK deployment..."

# Ensure storage directories exist
echo "📁 Creating storage directories..."
mkdir -p storage/framework/{sessions,views,cache}
mkdir -p storage/logs
mkdir -p bootstrap/cache

# Set permissions
echo "🔐 Setting permissions..."
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# Create .env if it doesn't exist (use environment variables from Render)
if [ ! -f .env ]; then
    echo "📝 Creating .env file from environment variables..."
    cat > .env << EOF
APP_NAME=\${APP_NAME:-SOOQLINK}
APP_ENV=\${APP_ENV:-production}
APP_KEY=\${APP_KEY:-}
APP_DEBUG=\${APP_DEBUG:-false}
APP_URL=\${APP_URL:-http://localhost}

LOG_CHANNEL=stack
LOG_LEVEL=debug

DB_CONNECTION=\${DB_CONNECTION:-mysql}
DB_HOST=\${DB_HOST:-127.0.0.1}
DB_PORT=\${DB_PORT:-3306}
DB_DATABASE=\${DB_DATABASE:-sooqlink}
DB_USERNAME=\${DB_USERNAME:-root}
DB_PASSWORD=\${DB_PASSWORD:-}

CACHE_DRIVER=\${CACHE_DRIVER:-file}
SESSION_DRIVER=\${SESSION_DRIVER:-file}
QUEUE_CONNECTION=\${QUEUE_CONNECTION:-sync}
EOF
fi

# Generate APP_KEY if not set
if [ -z "$APP_KEY" ]; then
    echo "🔑 Generating APP_KEY..."
    php artisan key:generate --force
fi

# Wait for database (if DB_HOST is set)
if [ ! -z "$DB_HOST" ]; then
    echo "⏳ Waiting for database at $DB_HOST:${DB_PORT:-3306}..."
    for i in {1..30}; do
        if nc -z "$DB_HOST" "${DB_PORT:-3306}" 2>/dev/null; then
            echo "✅ Database is ready!"
            break
        fi
        echo "   Attempt $i/30..."
        sleep 2
    done
fi

# Run migrations (only if database is configured)
if [ ! -z "$DB_HOST" ]; then
    echo "🗄️  Running database migrations..."
    php artisan migrate --force --no-interaction || echo "⚠️  Migrations failed (might be first run)"
fi

# Clear all caches
echo "🧹 Clearing caches..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Cache configuration for production
echo "⚡ Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Create storage link
echo "🔗 Creating storage link..."
php artisan storage:link || echo "⚠️  Storage link already exists"

# Final permissions
echo "🔒 Final permission adjustments..."
chown -R www-data:www-data /var/www/html
chmod -R 775 storage bootstrap/cache

echo "✅ Deployment complete! Starting Apache..."

# Start Apache in foreground
exec apache2-foreground

