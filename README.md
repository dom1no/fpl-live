## FPL Live

Проект интеграции с Fantasy Premier League. Дополнение недостающих функций, аналитики.
Возможности:
- Просматривать составы и таблицу лиги с live очками (во время матчей рассчитываются сразу)
- Просматривать очки и статистику игроков в рамках матча
- Получать уведомления в телеграмм-боте о действиях своих игроков во время матчей, начале и окончании матча, и другие
- И все это без VPN :)

## Основной стэк:
- PHP 8.1
- Laravel 9
- MySQL 5.7/8
- Laravel Pint
- Pest

### Также используется:
- Laravel Sail (опционально)
- Laravel Envoy
- Blade Icons
- Argon Dashboard Laravel
- Saloon
- Larastan

## Установка

1. Клонируем репозиторий 

    `git clone git@github.com:dom1no/fpl-live.git`

2. Переходим в папку проекта

    `cd fpl-live`

3. Устанавливаем зависимости

    `composer install`

4. Создаём .env файл 

   `composer run-script post-root-package-install`

5. Генерируем уникальный ключ приложения

    `composer run-script post-create-project-cmd`

6. Установка Laravel Sail или Laravel Valet(для Mac)
   - Laravel Sail:
     - Устанавливаем Laravel Sail
     `php artisan sail:install`
     - Запускаем проект через Laravel Sail
     `vendor/bin/sail up -d`
     - Проект доступен по адресу http://localhost
   - Laravel Valet(для Mac)
     - Устанавливаем Laravel Valet: [Инструкция](https://laravel.com/docs/9.x/valet)
     - Запускаем проект через Laravel Valet: `valet link`
     - Проект доступен по адресу: http://fpl-live.test

7. Запускаем миграции

   `php artisan migrate`

8. Запускаем импорт данных (нужен VPN):

    `sh init-data.sh`

## Линтеры

### Laravel Pint
  - `composer lint` - проверка код-стайла
  - `composer lint-fix` - проверка код-стайла с исправлением
  - Правила настраиваются в файле `pint.json`

### Larastan
  - `composer larastan` - статический анализ кода
  - Правила настраиваются в файле `phpstan.neon`

## Тесты

### Pest
  - `composer test`
