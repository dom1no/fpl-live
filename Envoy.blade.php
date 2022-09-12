@setup
    $projectPath = '/var/www/kuprovru/data/www/kuprov.ru/fpl';
    $composer = 'php /var/www/kuprovru/data/bin/composer';
@endsetup

@servers(['local' => '127.0.0.1', 'remote' => 'kuprovru@185.132.132.139 -p 21201'])

@task('deploy', ['on' => 'remote'])
    echo "Starting deployment..."

    cd {{ $projectPath }}

    php artisan optimize:clear
    git reset --hard HEAD
    git checkout main
    git pull origin main

    {{ $composer }} install --no-dev --prefer-dist --no-scripts -o -n
    {{ $composer }} du

    php artisan migrate --force

    php artisan optimize
    php artisan icons:cache

    echo "Application deployed!"
@endtask

@task('reimport', ['on' => 'remote', 'confirm' => true])
    cd {{ $projectPath }}
    php artisan down

    php artisan migrate:fresh --force
    sh init-data.sh

    php artisan up
@endtask

@task('local-reimport', ['on' => 'local', 'confirm' => true])
    php artisan migrate:fresh
    sh init-data.sh
@endtask
