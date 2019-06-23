# Activate Laravel maintenance mode
php artisan down

# Get the updated version of the code
git pull origin master

# Install/update dependencies
composer install
yarn install

# Migrate database
php artisan migrate

# Laravel Mix Tasks
yarn production

# Clear cache
php artisan cache:clear

# Restart queue workers
php artisan queue:restart

# Cache routes
php artisan route:cache

# Cache config files
php artisan config:cache

# Compile Laravel views and classes
php artisan optimize

# Restart PHP FPM
echo "" | sudo -S service php7.2-fpm reload

# Deactivate Laravel maintenance mode
php artisan up
