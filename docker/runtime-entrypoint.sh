#!/bin/sh
set -eu

/usr/local/bin/gcconnex-check-runtime
exec /var/www/html/docker/start.sh "$@"
