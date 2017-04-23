#!/usr/bin/env bash
echo "-- Environment $CONTAINER_ENV"
if [ ! "production" == "$CONTAINER_ENV" ] && [ ! "prod" == "$CONTAINER_ENV" ]; then
    # Enable xdebug

    ## FPM
    ln -sf /etc/php/7.0/mods-available/xdebug.ini /etc/php/7.0/fpm/conf.d/20-xdebug.ini

    ## CLI
    ln -sf /etc/php/7.0/mods-available/xdebug.ini /etc/php/7.0/cli/conf.d/20-xdebug.ini

    ## Update New Relic APP Name
    sed -i "s/newrelic\.appname \=.*/newrelic\.appname = \"Web-test\"/g" /etc/php/7.0/mods-available/newrelic.ini

    # Config /etc/php/7.0/mods-available/xdebug.ini
    sed -i "s/xdebug\.remote_host\=.*/xdebug\.remote_host\=$XDEBUG_HOST/g" /etc/php/7.0/mods-available/xdebug.ini

    sed -i "s/opcache\.validate_timestamps\=0/opcache\.validate_timestamps\=1/g" /etc/php/7.0/mods-available/opcache.ini
else
    # Disable xdebug

    ## FPM
    if [ -e /etc/php/7.0/fpm/conf.d/20-xdebug.ini ]; then
        rm -f /etc/php/7.0/fpm/conf.d/20-xdebug.ini
    fi

    ## CLI
    if [ -e /etc/php/7.0/cli/conf.d/20-xdebug.ini ]; then
        rm -f /etc/php/7.0/cli/conf.d/20-xdebug.ini
    fi
fi

echo "-- Installing cronjobs from /var/home/cronjobs.conf"
crontab /var/home/cronjobs.conf;
service cron start

echo "-- Executing supervisord"
/usr/bin/supervisord;