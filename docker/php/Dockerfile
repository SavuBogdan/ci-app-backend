FROM php:8.2-fpm-alpine

USER root

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
		git \
        openssh-client


RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions \
    apcu \
    pdo_mysql \
    intl \
    opcache \
    zip \
    gd \
    xdebug \
    amqp


# Set the working directory in the container
WORKDIR /var/www/html

# Create a new user with UID 1000 and GID 1000
RUN addgroup -g 1000 appuser && adduser -u 1000 -G appuser -s /bin/sh -D appuser

# Set the ownership and permissions
RUN chown -R appuser:appuser /var/www/html \
    && chmod -R 755 /var/www/html

# Create the .ssh directory and copy SSH configuration files
RUN mkdir -p /home/appuser/.ssh && \
    chmod 700 -R /home/appuser/.ssh && \
    touch /home/appuser/.ssh/config && \
    chmod 700 -R /home/appuser/.ssh/config


# Switch to the appuser
USER appuser

COPY --from=composer:2.5.5 /usr/bin/composer /usr/bin/composer


# Create and switch Docker context
RUN set -eux \
    && docker context create ci-context \
    && docker context use ci-context

# Start the application
CMD ["php-fpm", "-F"]

