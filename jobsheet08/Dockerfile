FROM php:8.3-cli

RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo_pgsql \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

COPY . .

ENV PORT=10000

EXPOSE 10000

CMD ["sh", "-c", "php -S 0.0.0.0:${PORT} -t /var/www/html"]