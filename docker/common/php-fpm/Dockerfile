# Stage 1: Build environment and Composer dependencies
FROM php:8.3-fpm AS builder

# Install system dependencies and PHP extensions required for Laravel + MySQL/PostgreSQL support
RUN apt-get update && apt-get install -y --no-install-recommends \
    curl \
    unzip \
    libpq-dev \
    libonig-dev \
    libssl-dev \
    libxml2-dev \
    libcurl4-openssl-dev \
    libicu-dev \
    libzip-dev \
    libldap2-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-configure ldap --with-libdir=lib/x86_64-linux-gnu/ \
    && docker-php-ext-install -j$(nproc) \
        pdo_mysql \
        pdo_pgsql \
        pgsql \
        opcache \
        intl \
        zip \
        bcmath \
        soap \
        ldap \
        gd \
    && pecl install redis xdebug \
    && docker-php-ext-enable redis xdebug \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && apt-get autoremove -y && apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*


# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

# Set the working directory
WORKDIR /var/www

# Copy composer files first for better layer caching
COPY composer.json composer.lock ./

# Create a minimal artisan stub to prevent post-autoload-dump errors
RUN echo '#!/usr/bin/env php' > artisan && \
    echo '<?php exit(0);' >> artisan && \
    chmod +x artisan

# Install Composer dependencies without running scripts initially
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

# Copy the entire Laravel application code (this will overwrite the stub artisan)
COPY . .

# Now run the post-autoload-dump scripts with the real artisan file
RUN composer dump-autoload --optimize --classmap-authoritative && \
    php artisan package:discover --ansi || true

# Stage 2: Production environment
FROM php:8.3-fpm AS production

# Install only runtime libraries needed in production
RUN apt-get update && apt-get install -y --no-install-recommends \
    # Database libraries
    libpq5 \
    # Internationalization
    libicu72 \
    # Archive handling
    libzip4 \
    # Health check dependencies
    libfcgi-bin \
    procps \
    # Image processing libraries
    libpng16-16 \
    libjpeg62-turbo \
    libfreetype6 \
    # String processing
    libonig5 \
    # XML processing
    libxml2 \
    # HTTP client
    libcurl4 \
    # LDAP (runtime only)
    libldap-2.5-0 \
    && apt-get autoremove -y \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Copy PHP extensions and configuration from builder
COPY --from=builder /usr/local/lib/php/extensions/ /usr/local/lib/php/extensions/
COPY --from=builder /usr/local/etc/php/conf.d/ /usr/local/etc/php/conf.d/

# Use production PHP configuration
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Configure PHP-FPM
RUN { \
    echo '[www]'; \
    echo 'pm.status_path = /status'; \
    echo 'ping.path = /ping'; \
    echo 'access.log = /proc/self/fd/2'; \
    echo 'clear_env = no'; \
    echo 'catch_workers_output = yes'; \
    echo 'decorate_workers_output = no'; \
    } >> /usr/local/etc/php-fpm.d/zz-docker.conf

# Add custom PHP configuration for Laravel
RUN { \
    echo 'opcache.enable=1'; \
    echo 'opcache.memory_consumption=256'; \
    echo 'opcache.interned_strings_buffer=16'; \
    echo 'opcache.max_accelerated_files=10000'; \
    echo 'opcache.revalidate_freq=2'; \
    echo 'opcache.fast_shutdown=1'; \
    echo 'opcache.enable_cli=1'; \
    echo 'opcache.validate_timestamps=0'; \
    echo 'realpath_cache_size=4096K'; \
    echo 'realpath_cache_ttl=600'; \
    echo 'memory_limit=512M'; \
    echo 'max_execution_time=60'; \
    echo 'max_input_vars=3000'; \
    echo 'upload_max_filesize=64M'; \
    echo 'post_max_size=64M'; \
    } > /usr/local/etc/php/conf.d/laravel.ini

# Download php-fpm health check script
RUN curl -o /usr/local/bin/php-fpm-healthcheck \
    https://raw.githubusercontent.com/renatomefi/php-fpm-healthcheck/master/php-fpm-healthcheck \
    && chmod +x /usr/local/bin/php-fpm-healthcheck

# Set working directory
WORKDIR /var/www

# Copy application code and dependencies from builder
COPY --from=builder --chown=www-data:www-data /var/www .

# Create and configure storage directories with proper permissions
RUN mkdir -p storage/{app,framework/{cache/data,sessions,testing,views},logs} bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Copy entrypoint script (make sure this file exists)
COPY --chmod=755 ./docker/production/php-fpm/entrypoint /usr/local/bin/entrypoint.sh

# Health check
HEALTHCHECK --interval=30s --timeout=3s --start-period=5s --retries=3 \
    CMD php-fpm-healthcheck || exit 1

# Switch to non-privileged user
USER www-data

# Set entrypoint and command
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
EXPOSE 9000
CMD ["php-fpm"]

# Stage 3: Development image
FROM production AS development

# Switch back to root for development setup
USER root

# Development build arguments
ARG XDEBUG_ENABLED=true
ARG XDEBUG_MODE=develop,coverage,debug,profile
ARG XDEBUG_HOST=host.docker.internal
ARG XDEBUG_IDE_KEY=DOCKER
ARG XDEBUG_LOG=/dev/stdout
ARG XDEBUG_LOG_LEVEL=0
ARG UID=1000
ARG GID=1000

# Install Composer for development
COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

# Install development dependencies
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    vim \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Configure Xdebug if enabled
RUN if [ "${XDEBUG_ENABLED}" = "true" ]; then \
    pecl install xdebug && \
    docker-php-ext-enable xdebug && \
    { \
    echo "xdebug.mode=${XDEBUG_MODE}"; \
    echo "xdebug.idekey=${XDEBUG_IDE_KEY}"; \
    echo "xdebug.log=${XDEBUG_LOG}"; \
    echo "xdebug.log_level=${XDEBUG_LOG_LEVEL}"; \
    echo "xdebug.client_host=${XDEBUG_HOST}"; \
    echo "xdebug.start_with_request=yes"; \
    echo "xdebug.discover_client_host=1"; \
    echo "xdebug.client_port=9003"; \
    } > /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
    fi

# Enable opcache validation in development
RUN sed -i 's/opcache.validate_timestamps=0/opcache.validate_timestamps=1/' /usr/local/etc/php/conf.d/laravel.ini

# Create development user with matching UID/GID
RUN if ! getent group ${GID} >/dev/null 2>&1; then \
    groupadd -g ${GID} devuser; \
    fi && \
    GROUP_NAME=$(getent group ${GID} | cut -d: -f1) && \
    if ! getent passwd ${UID} >/dev/null 2>&1; then \
    useradd -m -u ${UID} -g ${GID} -s /bin/bash devuser; \
    fi

# Update php-fpm configuration for development user
RUN USER_NAME=$(getent passwd ${UID} | cut -d: -f1) && \
    GROUP_NAME=$(getent group ${GID} | cut -d: -f1) && \
    sed -i "s/user = www-data/user = ${USER_NAME}/g" /usr/local/etc/php-fpm.d/www.conf && \
    sed -i "s/group = www-data/group = ${GROUP_NAME}/g" /usr/local/etc/php-fpm.d/www.conf

# Install development dependencies
RUN composer install --optimize-autoloader

# Update file permissions for development user
RUN USER_NAME=$(getent passwd ${UID} | cut -d: -f1) && \
    chown -R ${UID}:${GID} /var/www && \
    chmod -R 775 storage bootstrap/cache

# Copy development entrypoint (make sure this file exists)
COPY --chmod=755 ./docker/development/php-fpm/entrypoint.sh /usr/local/bin/entrypoint-dev.sh

# Switch to development user
USER ${UID}:${GID}

# Override entrypoint for development
ENTRYPOINT ["/usr/local/bin/entrypoint-dev.sh"]
EXPOSE 9000
CMD ["php-fpm"]
