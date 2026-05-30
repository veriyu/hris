#!/bin/bash

# ==============================================================================
# HRMS Deployment Script
# ==============================================================================
# Petunjuk: 
# Skrip ini disiapkan untuk di-run pada root folder aplikasi di VPS Ubuntu.
# Pastikan Anda telah menset environment .env production dengan benar.
# ==============================================================================

# Exit on error
set -e

echo "🚀 Starting HRMS deployment..."

# 1. Masuk ke maintenance mode (opsional, untuk mencegah akses user saat deploy)
echo "🔒 Entering maintenance mode..."
php artisan down || true

# 2. Pull terbaru dari repository
echo "📥 Pulling latest code..."
# git pull origin main

# 3. Instal dependensi Composer (tanpa require-dev untuk production)
echo "📦 Installing PHP dependencies..."
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# 4. Instal dependensi NPM dan compile asset (Filament / Vite)
echo "🎨 Compiling frontend assets..."
npm ci
npm run build

# 5. Clear cache framework
echo "🧹 Clearing application cache..."
php artisan optimize:clear

# 6. Jalankan migrasi database
echo "🗄️ Running database migrations..."
php artisan migrate --force

# 7. Cache konfigurasi dan route untuk Production
echo "⚡ Optimizing application (Cache)..."
php artisan optimize
php artisan view:cache
php artisan event:cache

# 8. Reload PHP-FPM (Ganti '8.3' dengan versi PHP Anda)
# echo "🔄 Reloading PHP-FPM..."
# sudo systemctl reload php8.4-fpm

# 9. Keluar dari maintenance mode
echo "🔓 Exiting maintenance mode..."
php artisan up

echo "✅ Deployment completed successfully!"
