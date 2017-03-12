#!/usr/bin/env bash

echo "-- Installing cronjobs from /var/home/cronjobs.conf"
crontab /var/home/cronjobs.conf;
service cron start

echo "-- Executing supervisord"
/usr/bin/supervisord;