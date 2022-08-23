## Информация

Laravel skeleton starter pack. Для быстрого старта разработки.

## Установка

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

Проект доступен по адресу http://localhost

Запускаем миграции

    php artisan migrate

## Дополнительно

[Решение возможных проблем](Troubleshooting.md)

[Варианты аутентификации](Authentication.md)
