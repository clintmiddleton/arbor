.DEFAULT_GOAL := help

setup: ## Run the initial setup to get sail up and running
	docker run --rm \
	-u "$$(id -u):$$(id -g)" \
	-v "$$(pwd):/var/www/html" \
	-w /var/www/html \
	laravelsail/php84-composer:latest \
	composer install --ignore-platform-reqs

up: ## Run sail up
	./vendor/bin/sail up -d

down: ## Run sail down
	./vendor/bin/sail down

rebuild: ## Remove containers, images, and volumes for this project and rebuild fresh
	./vendor/bin/sail down -v
	docker compose -p $$(basename $$(pwd)) rm -fsv
	docker image prune -f
	./vendor/bin/sail up -d --build

shell: ## Enter the sail shell for artisan and composer commands
	./vendor/bin/sail shell

mysql: ## Enter the mysql container as root
	./vendor/bin/sail mysql -uroot

db-reset: ## Reset database: migrate:fresh and seed
	./vendor/bin/sail artisan migrate:fresh --seed

pint: ## Run Laravel Pint (code style)
	./vendor/bin/sail exec laravel.test ./vendor/bin/pint

stan: ## Run PHPStan (static analysis)
	./vendor/bin/sail exec laravel.test ./vendor/bin/phpstan analyse

format: ## Format frontend with Prettier
	./vendor/bin/sail npm run format

format-check: ## Check frontend formatting
	./vendor/bin/sail npm run format:check

serve: ## Run sail up and composer run-dev
	./vendor/bin/sail exec laravel.test npm run dev

.PHONY: help
help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'
