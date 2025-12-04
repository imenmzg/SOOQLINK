#!/bin/bash
set -e

echo "🚀 Render Build Script - SOOQLINK"

# Install Composer dependencies
echo "📦 Installing Composer dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

# Create necessary directories
echo "📁 Creating storage directories..."
mkdir -p storage/framework/{sessions,views,cache}
mkdir -p storage/logs
mkdir -p bootstrap/cache

# Set permissions
echo "🔐 Setting permissions..."
chmod -R 775 storage bootstrap/cache

echo "✅ Build complete!"

