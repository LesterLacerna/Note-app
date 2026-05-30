#!/bin/bash
cd /var/www/html
php artisan config:clear
php artisan migrate --force --no-interaction
apache2-foreground