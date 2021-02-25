# rest-test

## Project setup
```
composer update
yarn install
Создать MySQL БД 'rest-test' ('username' => 'root', 'password' => 'root', 'charset' => 'utf8')
php yii migrate
Скорректировать файл среды .env
```

### Compiles and hot-reloads for development
```
yarn serve
```

### Compiles and minifies for production
```
yarn build
```

### Lints and fixes files
```
yarn lint
```

## Замечания к тестовому заданию

```
Yii2 и Vue2 в одной общей папке.
Взаимодействуют благодаря vue.config.js.
В данном случае так удобнее.

Публичная папка: web
В файле web/.htaccess сконфигурирован CORS
Изменения можно отследить по коммитам
CRUD, поиск, пагинация, валидация на стороне сервера и клиента.

Кэширование на стороне сервера не предусмотрено в рамках этой задачи.
Vagrant, Docker, Docker-compose не настроены.
REST Аутентификация не настроена.
```