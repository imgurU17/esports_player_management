FROM php:8.2-apache

# Enable Apache rewrite module
RUN a2enmod rewrite

# Enable PDO MySQL
RUN docker-php-ext-install pdo pdo_mysql

# Copy project files
COPY . /var/www/html/

# Set permissions
RUN chown -R www-data:www-data /var/www/html

# Render uses the PORT environment variable
CMD sed -i "s/Listen 80/Listen ${PORT:-10000}/" /etc/apache2/ports.conf && \
    sed -i "s/:80>/:${PORT:-10000}>/g" /etc/apache2/sites-available/000-default.conf && \
    apache2-foreground