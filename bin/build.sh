#!/usr/bin/env bash

docker compose exec -ti php php bin/console doctrine:database:drop --force
docker compose exec -ti php php bin/console doctrine:database:create
docker compose exec -ti php php bin/console doctrine:migrations:migrate --no-interaction
docker compose exec -ti php php bin/console doctrine:fixtures:load --no-interaction