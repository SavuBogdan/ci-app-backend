FROM php:8.2-fpm-alpine


ENV COMPOSER_HOME=/tmp/composer
ENV COMPOSER_MEMORY_LIMIT=-1

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

# Install Docker client
RUN apk update && \
    apk add --no-cache docker-cli


RUN apk add --no-cache \
		acl \
		fcgi \
		file \
		gettext \
		git


RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions \
    apcu \
    pdo_mysql \
    intl \
    opcache \
    zip \
    gd \
    xdebug


# Set the working directory in the container
WORKDIR /var/www/html

COPY --from=composer:2.5.5 /usr/bin/composer /usr/bin/composer


# Create and switch Docker context
RUN set -eux \
    && docker context create ci-context \
    && docker context use ci-context

# Start the application
CMD ["php-fpm", "-F"]

