#!/bin/sh
set -e

echo "==> Checking vendor..."
if [ ! -f "vendor/autoload.php" ]; then
    echo "==> Running composer install..."
    composer install --optimize-autoloader --no-dev
fi

echo "==> Checking .env..."
if [ ! -f ".env" ]; then
    echo "==> Copying .env.example to .env..."
    cp .env.example .env
    echo "==> Generating APP_KEY..."
    php artisan key:generate --force
fi

echo "==> Running migrations..."
php artisan migrate --force

echo "==> Clearing caches..."
php artisan cache:clear
php artisan config:clear

echo "==> Caching config & routes..."
php artisan config:cache
php artisan route:cache

echo "==> Starting PHP-FPM..."
exec php-fpm
