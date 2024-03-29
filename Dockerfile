FROM php:7.3.33-apache

# install zip, composer
ENV COMPOSER_ALLOW_SUPERUSER 1
RUN apt-get update && \
	apt-get install -y apache2 && \
	apt-get install -y zip && \
	curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Apache setup
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf && \
	sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf && \
	a2enmod rewrite

# add source code and dependencies
COPY . /var/www/html
WORKDIR /var/www/html
RUN composer install

# Laravel setup
RUN chmod -R 777 /var/www/html/storage && \
	cp .env.example .env && \
	php artisan key:generate
