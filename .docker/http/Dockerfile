FROM nginx:1.8.1-alpine

ARG COMPOSE_PROJECT_NAME

COPY nginx.conf nginx.conf

RUN envsubst '$COMPOSE_PROJECT_NAME' \
    < nginx.conf \
    > /etc/nginx/conf.d/default.conf \
  && rm nginx.conf \
  && id -g www-data &>/dev/null || addgroup -g 82 -S www-data 2>/dev/null \
  && id -u www-data &>/dev/null || adduser -u 82 -D -S -G www-data www-data 2>/dev/null \
  && mkdir -p /var/www/html \
  && chown -R www-data:www-data /var/www/html

WORKDIR /var/www/html
