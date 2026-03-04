#!/bin/sh
set -e

# Bootstrap Laravel (needs APP_KEY from runtime env)
php artisan package:discover --ansi
php artisan filament:upgrade
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Ensure the database file exists
mkdir -p /var/www/html/database
touch /var/www/html/database/database.sqlite

# Run migrations
php artisan migrate --force

# Seed only if categories table is empty
COUNT=$(php artisan tinker --execute="echo App\Models\Category::count();" 2>/dev/null | tail -1 | tr -d '\n\r ')
if [ "$COUNT" = "0" ] || [ -z "$COUNT" ]; then
    echo "Seeding database..."
    php artisan db:seed --force
fi

# Start server
exec php artisan serve --host=0.0.0.0 --port=8000
