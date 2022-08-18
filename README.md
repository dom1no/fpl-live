## Info

Laravel skeleton starter pack. Для быстрого старта разработки.

## Install

Клонируем репозиторий 

    git clone https://github.com/d3po13/laravel-skeleton.git

или

    git clone git@github.com:d3po13/laravel-skeleton.git

Переходим в папку проекта

Устанавливаем зависимости

    composer install

Создаём .env файл 

    composer run-script post-root-package-install

Генерируем уникальный ключ приложения

    composer run-script post-create-project-cmd

Устанавливаем Laravel Sail

    php artisan sail:install

Запускаем проект через Laravel Sail

    vendor/bin/sail up -d

Если контейнер laravel.test не запускается, то необходимо прописать порт в .env файле и заново установить Sail

    APP_PORT=8080

Проект доступен по адресу http://localhost
