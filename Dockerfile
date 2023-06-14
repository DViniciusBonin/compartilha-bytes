FROM php:7-apache


RUN a2enmod ssl

RUN a2enmod rewrite

COPY apache/override.conf /etc/apache2/conf-available/
RUN a2enconf override

RUN docker-php-ext-install pdo
RUN docker-php-ext-install pdo_mysql

COPY ./scripts/init_uploads.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/init_uploads.sh

CMD ["/bin/bash", "-c", "/usr/local/bin/init_uploads.sh && apache2-foreground"]
