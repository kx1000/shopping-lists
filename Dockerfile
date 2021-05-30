FROM php:7.4-apache

# Symfony configuration
RUN a2dissite 000-default.conf
RUN a2enmod rewrite
COPY ./.docker/symfony.conf /etc/apache2/sites-available
RUN a2ensite symfony.conf

# PHP dependecies
RUN apt-get update
RUN apt-get install -y libzip-dev
RUN docker-php-ext-install mysqli pdo pdo_mysql zip && docker-php-ext-enable pdo_mysql

WORKDIR /var/www/html/symfony

COPY . .

RUN php composer.phar install

EXPOSE 80

CMD ["apache2-foreground"]