COMPOSE=docker-compose
PHP=$(COMPOSE) exec php
CONSOLE=$(PHP) bin/console
COMPOSER=$(PHP) composer

up:
	@${COMPOSE} up -d

down:
	@${COMPOSE} down

clear:
	@${CONSOLE} cache:clear

encore_dev:
	@${COMPOSE} run node yarn encore dev --watch

encore_prod:
	@${COMPOSE} run node yarn encore production