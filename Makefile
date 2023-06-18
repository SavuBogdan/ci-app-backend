
#export COMPOSE_PROJECT_NAME=licenta
export UID=1000
export GID=1000
PHP_CONTAINER=php

install: down build up

nl: nginx-logs

nginx-logs:
	@docker-compose logs -f nginx

gitlab-logs:
	@docker-compose logs --tail=10 gitlab

reload-nginx:
	@docker-compose stop nginx
	@docker-compose build nginx
	@docker-compose up -d
	@docker-compose logs -f nginx

build:
	@docker-compose build --pull

up:
	@docker-compose up -d --remove-orphans

down:
	@docker-compose down --remove-orphans

clean: down
	docker system prune -f
	docker volume prune -f
	docker network prune -f
	
sh-php:
	@docker-compose exec php /bin/sh

db: generate-sql-database

generate-sql-database:
	@docker-compose run -T --rm $(PHP_CONTAINER) bin/console doctrine:database:drop --force --no-interaction --if-exists
	@docker-compose run -T --rm $(PHP_CONTAINER) bin/console doctrine:database:create  --no-interaction --if-not-exists
	@docker-compose run -T --rm $(PHP_CONTAINER) bin/console doctrine:migrations:migrate  --no-interaction
	@#docker-compose run -T --rm $(PHP_CONTAINER) bin/console doctrine:fixture:load  --no-interaction

sh-node:
	@docker-compose exec node /bin/sh

sh-nginx:
	@docker-compose exec nginx /bin/sh

