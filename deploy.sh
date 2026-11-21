#!/bin/bash
# ==============================================================================
# DiagnoLap — Automated Production Deployment Script
# ==============================================================================
# Script ini digunakan untuk deploy aplikasi ke server Linux production.
# Penggunaan: bash deploy.sh
# ==============================================================================

set -e # Exit immediately if a command exits with a non-zero status

echo "🚀 Starting DiagnoLap Production Deployment..."

# 1. Enable maintenance mode
echo "🔒 Enabling maintenance mode..."
php artisan down

# 2. Fetch latest code (if using git)
if [ -d ".git" ]; then
    echo "📥 Pulling latest code from git..."
    git pull origin main
fi

# 3. Install composer dependencies (no dev, optimized autoloader)
echo "📦 Installing Composer dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

# 4. Clear and rebuild caches
echo "⚡ Optimizing Laravel caches..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

php artisan config:cache
php artisan route:cache
php artisan view:cache

# 5. Run database migrations safely
echo "🗄️ Running database migrations..."
php artisan migrate --force

# 6. Build frontend assets if npm is present
if command -v npm &> /dev/null; then
    echo "🎨 Building frontend production assets..."
    npm ci || npm install
    npm run build
fi

# 7. Disable maintenance mode
echo "🔓 Disabling maintenance mode..."
php artisan up

echo "✅ DiagnoLap Deployment Completed Successfully!"
