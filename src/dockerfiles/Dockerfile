FROM php:8.2-fpm-alpine

ARG APP_ENV=prod
ARG WITH_XDEBUG=false
ENV APP_ENV=${APP_ENV}
ENV APP_PATH=/var/www

ARG GID=1000
ARG UID=1000

# alpine php already includes a www-data user, so its not needed to create
# we just create an unpriveledged user for our application. We set the 1000 id, so the permissions work
# when mounting the application volume. Need to investigate further to avoid this.
RUN addgroup app -g $GID && adduser -u $UID -D -G app app && addgroup app www-data


RUN set -eux; \
        apk add --no-cache --virtual .build-deps \
                $PHPIZE_DEPS \
                curl-dev \
                freetype-dev \
                icu-dev \
                gmp-dev \
                libidn-dev \
                imagemagick-dev \
                libevent-dev \
                libjpeg-turbo-dev \
                libpng-dev \
                libxpm-dev \
                libgcrypt-dev \
                libpq-dev \
                libvpx-dev \
                libxslt-dev \
                libwebp-dev \
                libzip-dev \
                linux-headers \
                zlib-dev \
        ; \
        \
        apk add --no-cache imagemagick; \
        docker-php-ext-install -j$(nproc) \
          bcmath \
          curl \
          exif \
          gd \
          gmp \
          intl \
          pcntl \
          opcache \
          pcntl \
          pdo \
          pdo_pgsql \
          sockets \
          xsl \
          zip \
        ; \
        pecl install \
          imagick \
          redis  \
        ; \
    	pecl clear-cache; \
        docker-php-ext-configure gd --enable-gd --with-webp --with-jpeg --with-xpm --with-freetype; \
        docker-php-ext-enable \
          imagick \
          redis  \
        ; \
        \
        runDeps="$( \
    		scanelf --needed --nobanner --format '%n#p' --recursive /usr/local/lib/php/extensions \
    			| tr ',' '\n' \
    			| sort -u \
    			| awk 'system("[ -e /usr/local/lib/" $1 " ]") == 0 { next } { print "so:" $1 }' \
    	)"; \
    	apk add --no-cache --virtual .api-phpexts-rundeps $runDeps; \
        if [ "$WITH_XDEBUG" == 'true' ] ; then \
          pecl install xdebug; \
          docker-php-ext-enable xdebug; \
        fi; \
        apk del --no-cache .build-deps ;

RUN set -eux; \
        apk --no-cache add tzdata; \
        cp /usr/share/zoneinfo/Europe/Moscow /etc/localtime; \
        echo "Europe/Moscow" >  /etc/timezone; \
        apk del --no-cache tzdata;


RUN set -eux; \
    if [ "$APP_ENV" == 'dev' ] ; then \
      #install ssh to work git in remote vscode
      apk add --no-cache git unzip grep dropbear-scp dropbear-ssh;\  
    fi ;


# Use the default production configuration
RUN set -eux; \
    if [ "$APP_ENV" == 'dev' ] || [ "$APP_ENV" == 'local' ] ; then \
      cp "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"; \
    else \
      cp "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"; \
    fi ;

# Install Composer globally
ENV COMPOSER_ALLOW_SUPERUSER 1
COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

WORKDIR ${APP_PATH}

COPY . ./

#RUN set -eux; \
    #composer install --prefer-dist --no-dev --optimize-autoloader --classmap-authoritative --no-progress; \
#	sync

COPY ./dockerfiles/php-${APP_ENV}.ini /usr/local/etc/php/conf.d/custom-php.ini
COPY ./dockerfiles/docker-php-entrypoint /usr/local/bin/docker-php-entrypoint

RUN set -eux; \
    chmod +x /usr/local/bin/docker-php-entrypoint;

USER app