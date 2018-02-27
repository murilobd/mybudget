#!/bin/bash
echo "initiating crontab laravel"
crontab /etc/cron.d/laravel

echo "initiating supervisord"
/usr/bin/supervisord

exec "$@"