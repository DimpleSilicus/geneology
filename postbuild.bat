call composer update
call php artisan vendor:publish --force
call php artisan migrate
call php artisan cache:clear
call php artisan config:clear
call php artisan config:cache
call php artisan view:clear
call composer dumpautoload
call php artisan optimize