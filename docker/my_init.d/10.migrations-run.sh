#!/bin/sh

cd /server/http

php vendor/bin/doctrine-migrations \
    --configuration=/server/http/config/migrations.yaml \
    migrations:migrate -n
