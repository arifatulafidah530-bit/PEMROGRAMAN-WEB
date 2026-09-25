FROM php:8.3-cli

RUN docker-php-ext-install pdo_pgsql

WORKDIR /var/www/html
COPY . .

ENV PORT=10000
EXPOSE 10000

CMD ["sh", "-c", "php -S 0.0.0.0:${PORT} -t /var/www/html"]
