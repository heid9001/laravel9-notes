## Laravel 9 Редактор заметок на основе AlpineJS

## Настройка
- .env нужно сопоставить с docker-compose сервисами
- DOCKER_UID и DOCKER_GID (.env) нужно установить равными ```id -u && id -g```
- создать директорию docker/db

## Запуск
```bash
docker compose up -d
docker compose exec fpm /bin/bash
npm install
npm run build
php artisan migrate
```
