#!/usr/bin/env bash
echo "Running composer"
cp /var/www/html/ ../.env.example
mv /var/www/html/.env.example /var/www/html/.env
composer install --no-dev --working-dir=/var/www/html

echo "Clearing caches..."
php artisan optimize:clear

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Running migrations..."
php artisan migrate --force

echo "Running NPM..."
npm install
npm run build

echo "done deploying"
