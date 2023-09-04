#!/usr/bin/env bash

SCRIPT_DIR="$( dirname -- "$( readlink -f -- "$0"; )"; )"
PROJECT_DIR="${SCRIPT_DIR%%bin}"

docker run -ti --rm -v "$PROJECT_DIR":/usr/src/app -w /usr/src/app -u "$(id -u)" node:lts npm "$@"