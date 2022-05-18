# Executables (local)
DOCKER_COMP = docker-compose

# Docker containers
PHP_CONT = $(DOCKER_COMP) exec php
APP_CONT = $(DOCKER_COMP) exec app

# Executables
PHP      = $(PHP_CONT) php
COMPOSER = $(PHP_CONT) composer

## Docker
build: ## Builds the Docker images
	@$(DOCKER_COMP) build --pull --no-cache

up: ## Start the docker hub in detached mode (no logs)
	@$(DOCKER_COMP) up --detach

start: build up ## Build and start the containers

down: ## Stop the docker hub
	@$(DOCKER_COMP) down --remove-orphans

logs: ## Show live logs
	@$(DOCKER_COMP) logs --tail=0 --follow

## Tests
launch-tests: ## Launch tests
	$(APP_CONT) php vendor/phpunit/phpunit/phpunit

create-db: ## Launch tests
	$(APP_CONT) php artisan migrate
