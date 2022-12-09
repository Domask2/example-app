FROM alpine:3.16

LABEL Description="Lightweight container with Nginx 1.22 & PHP 8.1 based on alpine"

# Add s6-overlay
ARG S6_OVERLAY_VERSION=3.1.1.2
ARG S6_ARCH=x86_64
ADD https://github.com/just-containers/s6-overlay/releases/download/v${S6_OVERLAY_VERSION}/s6-overlay-noarch.tar.xz /tmp
ADD https://github.com/just-containers/s6-overlay/releases/download/v${S6_OVERLAY_VERSION}/s6-overlay-${S6_ARCH}.tar.xz /tmp
RUN \
    tar -C / -Jxpf /tmp/s6-overlay-noarch.tar.xz && \
    tar -C / -Jxpf /tmp/s6-overlay-${S6_ARCH}.tar.xz && \
    rm /tmp/s6-overlay*.tar.xz

# Install packages
# Add script install extension fnd install php extension
# ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
# RUN chmod +x /usr/local/bin/install-php-extensions && sync && \
#     install-php-extensions bcmath imagick mysqli zip opcache gd
# Chmod files and directories, install php modules
RUN \
    apk -U --no-cache add \
    curl \
    nginx \
    php81 \
    php81-fpm \
    php81-bcmath \
    php81-ctype \
    php81-curl \
    php81-dom \
    php81-exif \
    php81-fileinfo \
    php81-json \
    php81-mbstring \
    php81-openssl \
    php81-phar \
    php81-pgsql \
    php81-pdo_pgsql \
    php81-session \
    php81-tokenizer \
    php81-xml \
    php81-xmlwriter && \
    ln -s /usr/bin/php81 /usr/bin/php && \
    ln -s /usr/sbin/php-fpm81 /usr/sbin/php-fpm && \
    addgroup -S php && \
    adduser -S -G php php && \
    rm -rf /var/cache/apk/* /etc/nginx/http.d/* /etc/php81/php-fpm.d/*

# Configure s6, php-fpm, nginx
COPY docker/rootfs /

# Set working directory
WORKDIR /www

# Copy all files with change permissions
COPY --chown=php:nginx . /www

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Change current user to 
# USER php

# Run composer
RUN composer install --no-dev --no-interaction -o

# Keygenerate
RUN php artisan key:generate --force

# Change permissions
RUN \
    rm -rf docker && \
    find /www -type d -exec chmod -R 755 {} \; && \
    find /www -type f -exec chmod -R 644 {} \; && \
    chown -R php:nginx /www && \
    chmod +x /etc/s6-overlay/scripts/start

# Expose the port nginx is reachable on
EXPOSE 8080

# Start container
ENTRYPOINT ["/init"]
# CMD ["sh"]

# Configure a healthcheck to validate that everything is up&running
HEALTHCHECK --interval=5s --timeout=5s CMD curl -f http://127.0.0.1:8080/php-fpm-ping || exit 1
