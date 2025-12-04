#!/bin/bash

# Wait for database to be ready
echo "Waiting for database..."
sleep 10

# Run migrations
php artisan migrate --force

# Clear and cache config
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Create storage link
php artisan storage:link

# Set proper permissions
chmod -R 755 /var/www/html/storage
chmod -R 755 /var/www/html/bootstrap/cache
chown -R www-data:www-data /var/www/html

# Start Apache
apache2-foreground

