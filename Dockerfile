FROM php:8.1-apache
RUN apt-get update && apt-get install -y libfreetype6-dev libxml2-dev libmcrypt-dev libc-client-dev git libzip-dev msmtp nano zip unzip curl qpdf
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
ENV TZ=Europe/Warsaw
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone
COPY php.ini /usr/local/etc/php/
RUN a2enmod rewrite
RUN sed -i -e 's~^ServerSignature On$~ServerSignature Off~g' -e 's~^ServerTokens OS$~ServerTokens Prod~g' /etc/apache2/apache2.conf && echo "ServerSignature Off" >> /etc/apache2/apache2.conf && echo "ServerTokens Prod" >> /etc/apache2/apache2.conf
RUN docker-php-ext-install pdo_mysql pdo mysqli zip gd calendar
WORKDIR /var/www
RUN mkdir tmp && chown www-data:www-data tmp
COPY public /var/www/html
COPY cron /var/www/cron
COPY composer.json /var/www
COPY composer.lock /var/www
RUN php /usr/local/bin/composer install --no-plugins --no-scripts  --no-dev
COPY src /var/www/src
USER www-data
