FROM php:8.2-apache

# Настройка Apache
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Установка зависимостей
RUN apt-get update && apt-get install -y \
    git \
    zip \
    curl \
    sudo \
    unzip \
    libicu-dev \
    libbz2-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    g++

# Установка расширений PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install \
    bz2 \
    intl \
    bcmath \
    opcache \
    calendar \
    pdo_mysql \
    mysqli \
    gd \
    mbstring \
    xml \
    zip

# Настройка виртуального хоста Apache
COPY docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# Включение модулей Apache
RUN a2enmod rewrite headers

# Настройка php.ini
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Установка Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN chmod +x /usr/local/bin/composer

# Создание пользователя
ARG uid
RUN useradd -G www-data,root -u $uid -d /home/devuser devuser
RUN mkdir -p /home/devuser/.composer && \
    chown -R devuser:devuser /home/devuser

# Копирование исходного кода
COPY src/ /var/www/html/

# Создание папки storage и установка прав
RUN mkdir -p /var/www/html/storage && \
    chown -R devuser:www-data /var/www/html && \
    chmod -R 775 /var/www/html/storage

EXPOSE 80