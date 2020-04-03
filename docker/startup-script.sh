#!/bin/bash

# Change into the webroot
cd /var/www/html

# Check if the environment variable APP_KEY or the .env-entry for APP_KEY is set.
# if not, abort with an error message
ENV_ENTRY=$(cat /var/www/html/.env | grep APP_KEY=)
if [ -z ${APP_KEY+x} ] && [ ${#ENV_ENTRY} -eq 9 ]
then
    echo "[Container Start Aborted] Please set the environment variable 'APP_KEY' for this container or mount a .env file containing that key @ /var/www/html/.env !"
    exit 1
elif [ ${#ENV_ENTRY} -gt 9 ]
then
    echo "Using APP_KEY from file"
elif [ -n ${APP_KEY+x} ]
then
    echo "Using APP_KEY from environment"
else
    echo "What???"
fi

# Cache the config. Must be done, if the environment of the container
# is different by a mounted .env-file or by set environment variables
php artisan config:cache

# Check if the database is available. If not, wait for 1 second and try again.
until php artisan app:check-db-connection; do
    sleep 1
done

# Run migrations
php artisan migrate

# startup apache2
apache2-foreground