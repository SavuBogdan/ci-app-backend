
export UID=1000
export GID=1000
PHP_CONTAINER=php
WORKERS_LABEL=workers

restart: stop-workers down up start-workers

install: down build up

nl: nginx-logs

sh-nginx:
	@docker-compose exec nginx /bin/sh

nginx-logs:
	@docker-compose logs -f nginx

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

remove-worker-containers:
	@CONTAINERS=$$(docker ps -aq --filter "label=$(WORKERS_LABEL)"); \
    if [ -n "$$CONTAINERS" ]; then \
        docker stop $$CONTAINERS; \
        echo "Containers with 'workers' label stopped and removed."; \
    else \
        echo "No containers with the 'workers' label were found."; \
    fi

stop-workers: stop-supervisor remove-worker-containers

stop-supervisor:
	sudo supervisorctl stop all
	sudo find /etc/supervisor/conf.d/ -type l -delete

start-workers:
	ls -al $(CURDIR)/config/supervisor/ci-tool/
	sudo ln -sfv $(CURDIR)/config/supervisor/ci-tool/*.conf /etc/supervisor/conf.d/
	sudo supervisorctl update
	sleep 5 # allow rabbitMq to start
	sudo supervisorctl start all

run-worker:
	@docker-compose run -T --rm --name=$(NAME) --label=$(WORKERS_LABEL) $(PHP_CONTAINER) bin/console messenger:consume $(WORKER) --limit=$(MESSAGES) -vv --memory-limit=$(MEMORY) --time-limit=3600

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

