FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
		libfreetype-dev \
		libjpeg62-turbo-dev \
		libpng-dev \
	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
	&& docker-php-ext-install -j$(nproc) gd\
    && docker-php-ext-install gd mysqli pdo pdo_mysql

WORKDIR /var/www/CampusConnect

COPY . /var/www/CampusConnect/

EXPOSE 9000

CMD ["php-fpm"]