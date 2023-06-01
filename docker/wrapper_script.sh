#!/bin/bash

# turn on bash's job control
set -m

# Apache is the primary process
./docker/run_apache &

# Memcached is the second process

./docker/run_memcached

# Bring the primary process back to foreground

fg %1