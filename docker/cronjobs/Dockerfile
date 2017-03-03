FROM ubuntu:16.04

MAINTAINER Enric Bisbe Gil

RUN locale-gen en_US.UTF-8

ENV LANG en_US.UTF-8
ENV LANGUAGE en_US:en
ENV LC_ALL en_US.UTF-8

RUN apt-get update \
    && apt-get install -y curl zip unzip git software-properties-common supervisor cron \
    && add-apt-repository -y ppa:ondrej/php \
    && apt-get update \
    && apt-get install -y php7.0-cli php7.0-mcrypt php7.0-redis php7.0-mongodb \
       php7.0-imap php-memcached php7.0-mbstring php7.0-xml php7.0-curl \
       php7.0-xdebug \
    && php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer \
    && mkdir /run/php \
    && apt-get remove -y --purge software-properties-common \
    && apt-get -y autoremove \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

COPY cronjobs.conf /var/home/

COPY start.sh /var/home/

RUN chmod +x /var/home/start.sh

CMD ["./var/home/start.sh"]
