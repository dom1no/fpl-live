#!/usr/bin/env sh

php artisan import:base-data
php artisan import:managers
php artisan import:fixtures
php artisan import:managers-picks
php artisan import:players-stats
