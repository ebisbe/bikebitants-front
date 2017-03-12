#!/usr/bin/env bash

echo "-- Installing cronjobs from /var/home/cronjobs.conf"
crontab /var/home/cronjobs.conf;

echo "-- Executing supervisord"
/usr/bin/supervisord;