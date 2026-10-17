# base: the image docker-compose.yml runs, with the checkout bind-mounted over /var/www
FROM php:8.5-fpm-trixie AS base

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg62-turbo-dev \
    libwebp-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libpq-dev

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# GD with JPEG and WebP, for re-encoding uploaded product images
RUN docker-php-ext-configure gd --with-jpeg --with-webp --with-freetype \
    && docker-php-ext-install pdo_pgsql mbstring exif pcntl bcmath gd

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

ARG UID=1000
RUN useradd -G www-data,root -u ${UID} -d /home/dev dev
RUN mkdir -p /home/dev/.composer && \
    chown -R dev:dev /home/dev

WORKDIR /var/www

COPY --chown=dev:www-data . /var/www

USER dev

# production: a self-contained image with the code baked in, no dev dependencies and Laravel's
# caches. Not used by docker-compose.yml (bind-mounted checkout, tests run in the container);
# meant for images built in CI. Build: docker build --target production -t wtech-production .
FROM base AS production
USER root
RUN mkdir -p storage/app/public storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs bootstrap/cache \
    && chown -R dev:www-data /var/www
USER dev
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress \
    && php artisan view:cache \
    && php artisan event:cache
# configuration and routes are cached at start, when the environment is known
CMD ["sh", "-c", "php artisan optimize && exec php-fpm"]

