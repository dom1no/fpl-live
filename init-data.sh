#!/usr/bin/env sh

php artisan import:teams
php artisan import:players
php artisan import:gameweeks
php artisan import:fixtures
php artisan import:managers
php artisan import:managers-picks
php artisan import:managers-transfers
php artisan import:managers-chips
php artisan import:players-stats

php artisan fot-mob:sync-teams
php artisan fot-mob:sync-fixtures --stats
