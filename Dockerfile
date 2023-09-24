FROM php:8.2-fpm-alpine
ARG uid=1000
ARG user=vin

RUN docker-php-ext-install pdo pdo_mysql

RUN wget https://raw.githubusercontent.com/composer/getcomposer.org/76a7060ccb93902cd7576b67264ad91c8a2700e2/web/installer -O - -q | php -- --quiet \
  && mv composer.phar /usr/local/bin/composer

RUN apk add --update-cache git curl zip unzip \
  && rm -rf /var/cache/apk/*

COPY . .

RUN adduser -u $uid -h /home/$user -D $user $user
RUN mkdir -p /home/$user/.composer && chown -R $user:$user /home/$user

USER $user

CMD ["composer", "install"]
CMD ["npm", "run", "build"]
CMD ["php", "artisan", "serve"]