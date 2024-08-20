FROM php:8.2-fpm
# debian slim 12.5

# php ext
RUN apt-get update && apt-get install -y \
    gnupg \
    g++ \
    procps \
    openssl \
    git \
    unzip \
    zlib1g-dev \
    libzip-dev \
    libfreetype6-dev \
    libpng-dev \
    libjpeg-dev \
    libicu-dev  \
    libonig-dev \
    libxslt1-dev \
    acl \
    default-libmysqlclient-dev \
    default-mysql-client \
    && docker-php-ext-configure gd --with-jpeg --with-freetype \
    && docker-php-ext-install \
    pdo pdo_mysql zip xsl gd intl opcache exif mbstring

# user init
ARG DOCKER_UID
ARG DOCKER_GID
RUN groupadd -g $DOCKER_GID app
RUN useradd -u $DOCKER_UID -g $DOCKER_GID -d /var/www/app app

# config
COPY conf/php.ini /usr/local/etc/php/conf.d/docker-fpm.ini
COPY conf/fpm.conf /usr/local/etc/php-fpm.d/zz-docker.ini

# npm install
RUN curl -fsSL https://deb.nodesource.com/setup_current.x | bash - \
    && apt-get install -y nodejs

# composer install
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN chmod a+rx /usr/bin/composer
WORKDIR /var/www/app

CMD bash -c "composer install -n && php-fpm"
