SHELL=/bin/bash

ifndef PHP_DOCKER_COMMAND
PHP_DOCKER_COMMAND=docker-compose exec php
endif

# Mute all `make` specific output. Comment this out to get some debug information.
.SILENT:


.PHONY: help
help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

##@ DEV Docker

.PHONY: up
up: ## start docker instances
	- docker-compose up -d

.PHONY: down
down: ## stop docker instances
	- docker-compose down -v

.PHONY: status
status: ## List containers
	- docker-compose ps

.PHONY: dev-tools
dev-tools: ## install dev tools
	- ${PHP_DOCKER_COMMAND} composer bin all update

.PHONY: test
test: ## Run phpunit
	- ${PHP_DOCKER_COMMAND} bin/phpunit

.PHONY: analyse
analyse: ## Run phpstan
#	- ${PHP_DOCKER_COMMAND} bin/console cache:warmup -e test
	- ${PHP_DOCKER_COMMAND} vendor/bin/phpstan analyse --debug

.PHONY: rector-check
rector-check: ## Run rector check
	- ${PHP_DOCKER_COMMAND} vendor/bin/rector process --config rector.php --dry-run

.PHONY: rector-fix
rector-fix: ## Run phpstan fix
	- ${PHP_DOCKER_COMMAND} vendor/bin/rector process --config rector.php
