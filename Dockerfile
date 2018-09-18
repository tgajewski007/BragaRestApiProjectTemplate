FROM php:7.2-apache
RUN apt-get update && apt-get upgrade -y && apt-get dist-upgrade -y && apt-get install -y libfreetype6-dev libxml2-dev libmcrypt-dev libc-client-dev libkrb5-dev git zip
ENV TZ=Europe/Warsaw
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone
COPY php.ini /usr/local/etc/php/
RUN a2enmod rewrite
RUN sed -i -e 's~^ServerSignature On$~ServerSignature Off~g' -e 's~^ServerTokens OS$~ServerTokens Prod~g' /etc/apache2/apache2.conf && echo "ServerSignature Off" >> /etc/apache2/apache2.conf && echo "ServerTokens Prod" >> /etc/apache2/apache2.conf
RUN docker-php-ext-configure imap --with-kerberos --with-imap-ssl
RUN docker-php-ext-install pdo_mysql
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php -r "if (hash_file('SHA384', 'composer-setup.php') === '544e09ee996cdf60ece3804abc52599c22b1f40f4323403c44d44fdfdd586475ca9813a858088ffbc1f233e9b180f061') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('/tmp/composer-setup.php'); } echo PHP_EOL;" && \
    php composer-setup.php && \
    php -r "unlink('composer-setup.php');"
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN service apache2 restart
COPY composer.json /var/www
WORKDIR /var/www
RUN mkdir log && chown www-data:www-data log
RUN mkdir tmp && chown www-data:www-data tmp
RUN php /usr/local/bin/composer update --no-plugins --no-scripts  --no-dev
COPY public /var/www/html
COPY cron /var/www/cron
COPY src /var/www/src
COPY adhoc /var/www/adhoc 
RUN ln -s html/ public