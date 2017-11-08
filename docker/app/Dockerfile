FROM ubuntu:16.04

MAINTAINER Enric Bisbe Gil

RUN locale-gen en_US.UTF-8

ENV LANG en_US.UTF-8
ENV LANGUAGE en_US:en
ENV LC_ALL en_US.UTF-8

RUN apt-get update \
    && apt-get install -y nginx curl zip unzip git wget software-properties-common supervisor cron \
    && echo 'deb http://apt.newrelic.com/debian/ newrelic non-free' | tee /etc/apt/sources.list.d/newrelic.list \
    && wget -O- https://download.newrelic.com/548C16BF.gpg | apt-key add -\
    && add-apt-repository -y ppa:ondrej/php \
    && apt-get update \
    && apt-get install -y php7.0-fpm php7.0-cli php7.0-mcrypt php7.0-gd php7.0-redis \
       php7.0-mongodb php7.0-imap php-memcached php7.0-mbstring php7.0-xml php7.0-curl \
       php7.0-xdebug \
    && apt-get install pngquant gifsicle jpegoptim \
    && php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer \
    && mkdir /run/php \
    && echo newrelic-php5 newrelic-php5/application-name string "Web" | debconf-set-selections \
    && echo newrelic-php5 newrelic-php5/license-key string "bd50325fb09190d6f55549675175d2765362766e" | debconf-set-selections \
    && apt-get install -y newrelic-php5 \
    && newrelic-install install \
    && rm /etc/php/7.0/cli/conf.d/newrelic.ini \
    && rm /etc/php/7.0/fpm/conf.d/newrelic.ini \
    && apt-get remove -y --purge software-properties-common \
    && apt-get -y autoremove \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* \
    && echo "daemon off;" >> /etc/nginx/nginx.conf

RUN ln -sf /dev/stdout /var/log/nginx/access.log \
    && ln -sf /dev/stderr /var/log/nginx/error.log

COPY default /etc/nginx/sites-available/default
COPY marketing.map /etc/nginx/marketing.map
COPY nginx.conf /etc/nginx/nginx.conf
COPY php-fpm.conf /etc/php/7.0/fpm/php-fpm.conf
COPY xdebug.ini /etc/php/7.0/mods-available/xdebug.ini
COPY opcache.ini /etc/php/7.0/mods-available/opcache.ini
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY www.conf /etc/php/7.0/fpm/pool.d/www.conf

COPY packaged /var/www/html
COPY cronjobs.conf /var/home/
COPY start.sh /var/home/

EXPOSE 80

RUN chown -R www-data: /var/www/html
RUN chmod +x /var/home/start.sh
CMD ["./var/home/start.sh"]