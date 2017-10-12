composer update
php artisan vendor:publish --force
php artisan migrate
php artisan cache:clear
php artisan config:clear
php artisan config:cache
php artisan view:clear
composer dumpautoload
php artisan optimize