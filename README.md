## Laravel 9 Редактор заметок на основе AlpineJS

## Настройка
- .env нужно сопоставить с docker-compose сервисами
- DOCKER_UID и DOCKER_GID (.env) нужно установить равными ```id -u && id -g```

## Запуск
```bash
mkdir docker/db
docker compose up -d
docker compose exec fpm /bin/bash
npm install
npm run build
php artisan migrate
```

### Возможные проблемы:
- директория docker/db ``` rm -rf docker/db; mkdir docker/db; docker compose build db --no-cache  ```
