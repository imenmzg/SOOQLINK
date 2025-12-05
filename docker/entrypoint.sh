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
    # Get APP_URL from environment or use default
    APP_URL_VALUE=\${APP_URL:-https://sooqlink.onrender.com}
    cat > .env << EOF
APP_NAME=\${APP_NAME:-SOOQLINK}
APP_ENV=\${APP_ENV:-production}
APP_KEY=\${APP_KEY:-}
APP_DEBUG=\${APP_DEBUG:-false}
APP_URL=\${APP_URL_VALUE}

LOG_CHANNEL=stack
LOG_LEVEL=debug
LOG_DEPRECATIONS_CHANNEL=null

DB_CONNECTION=\${DB_CONNECTION:-mysql}
DB_HOST=\${DB_HOST:-127.0.0.1}
DB_PORT=\${DB_PORT:-3306}
DB_DATABASE=\${DB_DATABASE:-sooqlink}
DB_USERNAME=\${DB_USERNAME:-root}
DB_PASSWORD=\${DB_PASSWORD:-}

CACHE_DRIVER=\${CACHE_DRIVER:-file}
SESSION_DRIVER=\${SESSION_DRIVER:-file}
SESSION_LIFETIME=120
QUEUE_CONNECTION=\${QUEUE_CONNECTION:-sync}

BROADCAST_DRIVER=log
FILESYSTEM_DISK=local

ASSET_URL=
VITE_APP_NAME=\${APP_NAME:-SOOQLINK}
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

# Clear all caches FIRST (before migrations)
echo "🧹 Clearing caches..."
php artisan config:clear || true
php artisan cache:clear || true
php artisan view:clear || true
php artisan route:clear || true

# Run migrations (only if database is configured)
if [ ! -z "$DB_HOST" ]; then
    echo "🗄️  Running database migrations..."
    
    # Check if migrations table exists, if not create it
    php artisan migrate:install --force 2>/dev/null || true
    
    # Run migrations with verbose output
    if php artisan migrate --force --no-interaction -v; then
        echo "✅ Migrations completed successfully!"
    else
        echo "⚠️  Migrations failed, but continuing..."
        # Try to run pending migrations only
        php artisan migrate --force --no-interaction 2>&1 || true
    fi
    
    # Verify migrations completed
    echo "📊 Migration status:"
    php artisan migrate:status 2>&1 | head -30 || echo "⚠️  Could not check migration status"
fi

# Test database connection before caching
if [ ! -z "$DB_HOST" ]; then
    echo "🔍 Testing database connection..."
    php artisan tinker --execute="DB::connection()->getPdo(); echo 'Database connected!';" || echo "⚠️  Database connection test failed"
fi

# Publish Filament assets FIRST (before caching)
echo "🎨 Publishing Filament assets..."
php artisan filament:assets --force 2>&1 || echo "⚠️  Filament assets publish failed"

# Clear Filament cache to ensure fresh asset loading
echo "🧹 Clearing Filament component cache..."
php artisan filament:cache-components 2>&1 || echo "⚠️  Filament cache clear failed"

# Create storage link
echo "🔗 Creating storage link..."
php artisan storage:link || echo "⚠️  Storage link already exists"

# Cache configuration for production (after migrations and asset publishing)
echo "⚡ Caching configuration..."
# Don't cache config if APP_DEBUG is true (helps with debugging)
if [ "$APP_DEBUG" != "true" ]; then
    php artisan config:cache || true
    php artisan route:cache || true
    php artisan view:cache || true
else
    echo "⚠️  Skipping config cache (APP_DEBUG=true for debugging)"
    php artisan config:clear || true
fi

# Ensure public assets are accessible
echo "📦 Ensuring public assets are accessible..."
chmod -R 755 /var/www/html/public || true
chown -R www-data:www-data /var/www/html/public || true

# Verify Filament assets were published
echo "🔍 Verifying Filament assets..."
if [ -d "/var/www/html/public/css/filament" ] && [ -d "/var/www/html/public/js/filament" ]; then
    echo "✅ Filament assets found in public directory"
    ls -la /var/www/html/public/css/filament/ | head -5 || true
    ls -la /var/www/html/public/js/filament/ | head -5 || true
else
    echo "⚠️  Filament assets not found - attempting to publish again..."
    php artisan filament:assets --force 2>&1 || true
fi

# Final permissions
echo "🔒 Final permission adjustments..."
chown -R www-data:www-data /var/www/html
chmod -R 775 storage bootstrap/cache
chmod -R 755 public

echo "✅ Deployment complete! Starting Apache..."

# Start Apache in foreground
exec apache2-foreground

