# =============================================================================
# STAGE 1: Composer Dependencies
# =============================================================================
FROM composer:2.7 AS composer
 
WORKDIR /app
 
# Copy only composer files first to leverage Docker layer caching
COPY composer.json composer.lock ./
 
# Install production dependencies only, no scripts, no autoload
RUN composer install \
    --no-dev \
    --no-scripts \
    --no-autoloader \
    --no-interaction \
    --prefer-dist \
    --ignore-platform-reqs
 
# Copy full source then generate optimized autoloader
COPY . .
RUN composer dump-autoload --optimize --no-dev
 
 
# =============================================================================
# STAGE 2: Node.js Assets (skip if API-only, no frontend assets)
# =============================================================================
FROM node:20-alpine AS node_builder
 
WORKDIR /app
 
COPY package*.json ./
RUN npm ci --omit=dev
 
COPY . .
RUN npm run build
 
 
# =============================================================================
# STAGE 3: Production PHP-FPM Image
# =============================================================================
FROM php:8.3-fpm-alpine AS production
 
# --------------------------------------------------------------------------
# System labels
# --------------------------------------------------------------------------
LABEL maintainer="your-team@example.com" \
      version="1.0" \
      description="Laravel WMS/VWM API - Production"
 
# --------------------------------------------------------------------------
# System dependencies & PHP extensions
# --------------------------------------------------------------------------
RUN apk add --no-cache \
        # Core utilities
        bash \
        curl \
        shadow \
        # PHP extension build deps
        $PHPIZE_DEPS \
        # MySQL / PDO
        mysql-client \
        # Image processing (if needed)
        libpng-dev \
        libjpeg-turbo-dev \
        freetype-dev \
        # ZIP support
        libzip-dev \
        zip \
        unzip \
        # String & intl
        icu-dev \
        oniguruma-dev \
    && docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo \
        pdo_mysql \
        mysqli \
        mbstring \
        zip \
        gd \
        intl \
        opcache \
        bcmath \
        pcntl \
        sockets \
    # Redis extension via PECL
    && pecl install redis \
    && docker-php-ext-enable redis \
    # Cleanup build deps to reduce image size
    && apk del $PHPIZE_DEPS \
    && rm -rf /var/cache/apk/* /tmp/pear
 
# --------------------------------------------------------------------------
# PHP configuration: php.ini & php-fpm tuning
# --------------------------------------------------------------------------
COPY docker/php/php.ini /usr/local/etc/php/conf.d/99-custom.ini
COPY docker/php/www.conf /usr/local/etc/php-fpm.d/www.conf
COPY docker/php/opcache.ini /usr/local/etc/php/conf.d/98-opcache.ini
 
# --------------------------------------------------------------------------
# Application user (non-root, matches nginx UID for file permission harmony)
# --------------------------------------------------------------------------
RUN addgroup -g 1000 www \
    && adduser -u 1000 -G www -s /bin/sh -D www
 
# --------------------------------------------------------------------------
# Application files
# --------------------------------------------------------------------------
WORKDIR /var/www/html
 
# Copy vendor from composer stage
COPY --from=composer --chown=www:www /app/vendor ./vendor
 
# Copy built frontend assets from node stage
COPY --from=node_builder --chown=www:www /app/public/build ./public/build
 
# Copy application source
COPY --chown=www:www . .
 
# --------------------------------------------------------------------------
# Laravel bootstrap
# --------------------------------------------------------------------------
RUN php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache \
    && php artisan event:cache
 
# --------------------------------------------------------------------------
# Directory permissions
# --------------------------------------------------------------------------
RUN mkdir -p \
        storage/framework/cache \
        storage/framework/sessions \
        storage/framework/views \
        storage/logs \
        bootstrap/cache \
    && chown -R www:www \
        storage \
        bootstrap/cache \
    && chmod -R 775 \
        storage \
        bootstrap/cache
 
# --------------------------------------------------------------------------
# Switch to non-root user
# --------------------------------------------------------------------------
USER www
 
# --------------------------------------------------------------------------
# Health check (php-fpm ping)
# --------------------------------------------------------------------------
HEALTHCHECK --interval=30s --timeout=10s --start-period=40s --retries=3 \
    CMD curl -f http://localhost/ping || exit 1
 
EXPOSE 9000
 
CMD ["php-fpm"]