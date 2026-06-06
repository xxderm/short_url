# Short Links API

Небольшой REST API сервис коротких ссылок на Laravel, PostgreSQL и Docker.

![Пример](/screenshot/1.png)

## Требования

- Docker
- Docker Compose
- Make

## Запуск проекта

```bash
make init
```

Команда выполнит:

1. Создание `.env` из `.env.example`.
2. Сборку и запуск Docker-контейнеров.
3. Установку Composer-зависимостей.
4. Генерацию Laravel app key.
5. Запуск миграций.

После запуска API будет доступно по адресу:

```text
http://localhost
```

## Ручной запуск

Выполнить init команды из Makefile:
```bash
	cp -n .env.example .env || true
	docker compose up -d --build
	docker compose exec app composer install
	docker compose exec app php artisan key:generate
	docker compose exec app php artisan migrate
```

## Остановка проекта

```bash
make down
```

## Перезапуск

```bash
make restart
```

## Подключение к контейнеру приложения

```bash
make bash
```

## Миграции

Запуск миграций:

```bash
make migrate
```

Пересоздание базы:

```bash
make fresh
```

## API

### 1. Создание короткой ссылки

```http
POST /api/links
```

Тело запроса:

```json
{
  "url": "https://example.com/some/very/long/path"
}
```

Пример curl:

```bash
curl -X POST http://localhost/api/links -H "Content-Type: application/json" -d '{"url":"https://example.com/some/very/long/path"}'
```

Ответ:

```json
{
  "code": "abc123",
  "short_url": "http://localhost/abc123"
}
```

Если такой URL уже сокращали ранее, будет возвращён существующий код.

### 2. Редирект по короткому коду

```http
GET /{code}
```

Пример:

```bash
curl -i http://localhost/abc123
```

Успешный ответ:

```http
302 Found
```

Если код не найден:

```json
{
  "message": "Link not found"
}
```

Статус:

```http
404 Not Found
```

### 3. Статистика

```http
GET /api/links/{code}/stats
```

Пример:

```bash
curl http://localhost/api/links/abc123/stats
```

Ответ:

```json
{
  "url": "https://example.com/some/very/long/path",
  "code": "abc123",
  "clicks": 42,
  "created_at": "2025-06-03T12:34:56.000000Z"
}
```

## Валидация

Поле `url`:

- обязательно;
- должно быть строкой;
- должно быть валидным URL;
- разрешены только схемы `http` и `https`;
- максимальная длина — 2048 символов.