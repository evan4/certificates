# certificates

Приложение сертификаты на покупку деревьев на laravel

## Развертывание проекта
Для установки php библиотек выполнить
``` 
composer install
```
Для настройки БД необходимо скопировать из .env.example в .env отредактировать файл

Для генерации бд провести миграции
``` 
php artisan migrate
```
Для создания тестовых данных в бд выполнить
``` 
php artisan db:seed
```
Для настройки почты отредактируйте в файле .env соотвествующие записи
``` 
MAIL_MAILER=smtp
...
```