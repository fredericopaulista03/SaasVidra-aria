#!/bin/bash

# Stop script on error
set -e

echo "🚀 Starting deployment..."

# 1. Pull the latest changes
echo "📦 Pulling latest changes..."
git pull origin main

# 2. Install/Update Composer dependencies
echo "🔧 Installing Composer dependencies..."
composer install --no-dev --optimize-autoloader

# 3. Run Database Migrations
echo "🗄️  Running migrations..."
php artisan migrate --force

# 4. Clear and Cache Config/Routes/Views
echo "🧹 Clearing and caching..."
php artisan optimize:clear
php artisan config:cache
php artisan event:cache
php artisan route:cache
php artisan view:cache

# 5. Build Frontend Assets (if needed on server)
echo "🎨 Building frontend assets..."
npm install
npm run build

# 6. Restart Queue Workers (if using Supervisor)
# echo "🔄 Restarting queue workers..."
# php artisan queue:restart

echo "✅ Deployment finished successfully!"
