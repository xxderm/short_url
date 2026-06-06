up:
	docker compose up -d --build

down:
	docker compose down

restart:
	docker compose down
	docker compose up -d --build

bash:
	docker compose exec app bash

install:
	docker compose exec app composer install

migrate:
	docker compose exec app php artisan migrate

fresh:
	docker compose exec app php artisan migrate:fresh

test:
	docker compose exec app php artisan test

logs:
	docker compose logs -f

ps:
	docker compose ps

key:
	docker compose exec app php artisan key:generate

init:
	cp -n .env.example .env || true
	docker compose up -d --build
	docker compose exec app composer install
	docker compose exec app php artisan key:generate
	docker compose exec app php artisan migrate