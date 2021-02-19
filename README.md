### Random Dogs App

Nginx + MySQL 8 + PHP 7.4 + phpmyadmin

```php
localhost:8080 // Web
localhost:8081 // phpmyadmin
```

Version of Laravel is 6 (LTS)

```code
git clone https://github.com/faleksandr/demo-api.git
docker-compose build && docker-compose up -d
```

To run migrations
```code
docker-compose exec php php artisan migrate
```

To create link to storage directory from public
```code
docker-compose exec php php artisan storage:link
```

To run tests
```code
docker-compose exec php php /var/www/html/vendor/bin/phpunit
```
