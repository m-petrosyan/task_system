## Instruction

```
copy .env.example .env
composer install
php artisan key:generate
PHP artisan migrate
PHP artisan db:seed

npm install
npm run dev
php artisan serve
```

### Users

```
email => user@gmail.com
password => 12345678

email => manager@gmail.com
password => 12345678
```

### Simulating a notification

```
php artisan app:make-notification-command
```

[API Documentation](https://documenter.getpostman.com/view/12599375/2sB3HtEbpG)