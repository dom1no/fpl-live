#!/usr/bin/env sh

php artisan import:base-data
php artisan import:fixtures
php artisan import:managers
php artisan import:managers-picks
php artisan import:managers-transfers
php artisan import:players-stats
