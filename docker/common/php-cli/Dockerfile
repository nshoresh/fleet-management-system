# Stage 1: Build environment and Composer dependencies
FROM php:8.3-cli AS builder

# Install system dependencies and PHP extensions required for Laravel + MySQL/PostgreSQL support
RUN apt-get update && apt-get install -y --no-install-recommends \
    curl \
    git \
    unzip \
    # Database dependencies
    libpq-dev \
    # String processing
    libonig-dev \
    # SSL/TLS
    libssl-dev \
    # XML processing
    libxml2-dev \
    # HTTP client
    libcurl4-openssl-dev \
    # Internationalization
    libicu-dev \
    # Archive handling
    libzip-dev \
    # LDAP support
    libldap2-dev \
    # Image processing (GD extension)
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
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apt-get autoremove -y \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Install Composer from official image
COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

# Set working directory
WORKDIR /var/www

# Copy composer files first for better Docker layer caching
COPY composer.json composer.lock ./

# Create a minimal artisan stub to prevent post-autoload-dump errors
RUN echo '#!/usr/bin/env php' > artisan && \
    echo '<?php exit(0);' >> artisan && \
    chmod +x artisan

# Install Composer dependencies without running scripts initially
RUN composer install --no-scripts --optimize-autoloader --no-interaction

# Copy the entire Laravel application code (this will overwrite the stub artisan)
COPY . .

# Now run the post-autoload-dump scripts with the real artisan file
RUN composer dump-autoload --optimize --classmap-authoritative && \
    php artisan package:discover --ansi || true

# Clear any unnecessary files for production
RUN rm -rf \
    /var/www/.git* \
    /var/www/tests \
    /var/www/phpunit.xml* \
    /var/www/README.md \
    /var/www/docker* \
    /var/www/node_modules \
    /var/www/package*.json \
    /var/www/webpack.mix.js \
    /var/www/vite.config.js

# Stage 2: Production environment
FROM php:8.3-cli AS production

# Install only runtime libraries needed for PHP extensions
RUN apt-get update && apt-get install -y --no-install-recommends \
    # Database runtime libraries
    libpq5 \
    # Internationalization
    libicu72 \
    # Archive handling
    libzip4 \
    # String processing
    libonig5 \
    # XML processing
    libxml2 \
    # HTTP client
    libcurl4 \
    # LDAP runtime libraries
    libldap-2.5-0 \
    # Image processing runtime libraries
    libpng16-16 \
    libjpeg62-turbo \
    libfreetype6 \
    # Additional utilities for CLI operations
    procps \
    && apt-get autoremove -y \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Copy PHP extensions and configuration from builder
COPY --from=builder /usr/local/lib/php/extensions/ /usr/local/lib/php/extensions/
COPY --from=builder /usr/local/etc/php/conf.d/ /usr/local/etc/php/conf.d/

# Use production PHP configuration as base
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Add optimized PHP configuration for CLI Laravel applications
RUN { \
    echo '; Laravel CLI Optimizations'; \
    echo 'opcache.enable=1'; \
    echo 'opcache.enable_cli=1'; \
    echo 'opcache.memory_consumption=256'; \
    echo 'opcache.interned_strings_buffer=16'; \
    echo 'opcache.max_accelerated_files=10000'; \
    echo 'opcache.revalidate_freq=2'; \
    echo 'opcache.fast_shutdown=1'; \
    echo 'opcache.validate_timestamps=0'; \
    echo 'opcache.save_comments=0'; \
    echo 'opcache.enable_file_override=1'; \
    echo ''; \
    echo '; Memory and execution settings'; \
    echo 'memory_limit=512M'; \
    echo 'max_execution_time=300'; \
    echo 'max_input_vars=3000'; \
    echo ''; \
    echo '; File upload settings'; \
    echo 'upload_max_filesize=64M'; \
    echo 'post_max_size=64M'; \
    echo ''; \
    echo '; Realpath cache optimization'; \
    echo 'realpath_cache_size=4096K'; \
    echo 'realpath_cache_ttl=600'; \
    echo ''; \
    echo '; Error handling'; \
    echo 'log_errors=On'; \
    echo 'error_log=/dev/stderr'; \
    } > /usr/local/etc/php/conf.d/laravel-cli.ini

# Set working directory
WORKDIR /var/www

# Copy application code and dependencies from builder with proper ownership
COPY --from=builder --chown=www-data:www-data /var/www .

# Create necessary directories and set permissions
RUN mkdir -p storage/{app,framework/{cache/data,sessions,testing,views},logs} bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Create a health check script for CLI applications
RUN echo '#!/bin/bash\nphp artisan --version > /dev/null 2>&1' > /usr/local/bin/health-check \
    && chmod +x /usr/local/bin/health-check

# Add health check
HEALTHCHECK --interval=30s --timeout=10s --start-period=5s --retries=3 \
    CMD /usr/local/bin/health-check || exit 1

# Switch to non-privileged user
USER www-data

# Default command - can be overridden
CMD ["php", "artisan", "list"]

# Stage 3: Development environment
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

# Install development tools and dependencies
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    vim \
    nano \
    htop \
    wget \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install Composer for development use
COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

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
    echo "xdebug.max_nesting_level=1000"; \
    } > /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
    fi

# Enable opcache validation in development and increase memory
RUN { \
    echo '; Development overrides'; \
    echo 'opcache.validate_timestamps=1'; \
    echo 'opcache.revalidate_freq=0'; \
    echo 'memory_limit=1G'; \
    echo 'max_execution_time=0'; \
    echo 'display_errors=On'; \
    echo 'display_startup_errors=On'; \
    echo 'error_reporting=E_ALL'; \
    } > /usr/local/etc/php/conf.d/laravel-cli-dev.ini

# Create development user with matching UID/GID
RUN if ! getent group ${GID} >/dev/null 2>&1; then \
    groupadd -g ${GID} devuser; \
    fi && \
    GROUP_NAME=$(getent group ${GID} | cut -d: -f1) && \
    if ! getent passwd ${UID} >/dev/null 2>&1; then \
    useradd -m -u ${UID} -g ${GID} -s /bin/bash -d /home/devuser devuser; \
    fi

# Update file permissions for development user
RUN USER_NAME=$(getent passwd ${UID} | cut -d: -f1) && \
    chown -R ${UID}:${GID} /var/www && \
    chmod -R 775 storage bootstrap/cache

# Install development dependencies (including dev packages)
RUN cd /var/www && composer install --optimize-autoloader

# Create convenient aliases for development
RUN echo 'alias artisan="php artisan"' >> /etc/bash.bashrc && \
    echo 'alias tinker="php artisan tinker"' >> /etc/bash.bashrc && \
    echo 'alias test="php artisan test"' >> /etc/bash.bashrc

# Switch to development user
USER ${UID}:${GID}

# Set environment variable for interactive shell
ENV PS1='\u@\h:\w\$ '

# Default command for development
CMD ["bash"]
