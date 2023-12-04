#!/usr/bin/env bash

SCRIPT_DIR="$( dirname -- "$( readlink -f -- "$0"; )"; )"
PROJECT_DIR="${SCRIPT_DIR%%bin}"

docker run -ti --rm -v "$PROJECT_DIR":/usr/src/app -w /usr/src/app -u "$(id -u)" node:lts npm run dev

docker compose exec -ti php php bin/console doctrine:database:drop --force
docker compose exec -ti php php bin/console doctrine:database:create
docker compose exec -ti php php bin/console doctrine:migrations:migrate --no-interaction
docker compose exec -ti php php bin/console doctrine:fixtures:load --no-interaction