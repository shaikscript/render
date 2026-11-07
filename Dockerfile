FROM php:8.2-apache
RUN apt-get update && apt-get install -y libpq-dev && docker-php-ext-install pdo_pgsql && rm -rf /var/lib/apt/lists/* \
 && a2enmod headers rewrite && sed -ri 's#AllowOverride None#AllowOverride All#' /etc/apache2/apache2.conf
COPY . /var/www/html/
RUN chown -R www-data:www-data /var/www/html/uploads
CMD sed -i "s/80/${PORT:-10000}/g" /etc/apache2/ports.conf /etc/apache2/sites-available/000-default.conf && apache2-foreground
