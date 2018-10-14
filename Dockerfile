FROM php:7.2-apache
RUN apt-get update && apt-get upgrade -y && apt-get dist-upgrade -y && apt-get install -y libfreetype6-dev libxml2-dev libmcrypt-dev libc-client-dev libkrb5-dev git zip
ENV TZ=Europe/Warsaw
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone
COPY php.ini /usr/local/etc/php/
RUN a2enmod rewrite
RUN sed -i -e 's~^ServerSignature On$~ServerSignature Off~g' -e 's~^ServerTokens OS$~ServerTokens Prod~g' /etc/apache2/apache2.conf && echo "ServerSignature Off" >> /etc/apache2/apache2.conf && echo "ServerTokens Prod" >> /etc/apache2/apache2.conf
RUN docker-php-ext-install soap pdo_mysql pdo mysqli zip
WORKDIR /var/www
RUN curl --silent --show-error https://getcomposer.org/installer | php
RUN service apache2 restart
COPY composer.json /var/www
RUN mkdir log && chown www-data:www-data log
RUN mkdir tmp && chown www-data:www-data tmp
RUN php /usr/local/bin/composer update --no-plugins --no-scripts  --no-dev
COPY public /var/www/html
COPY src /var/www/src
COPY loggerConfig-docker.xml /var/www/config/loggerConfig.xml