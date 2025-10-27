# Use official PHP 8.2 with Apache
FROM php:8.2-apache

# Install necessary PHP extensions for Laravel
RUN docker-php-ext-install pdo pdo_mysql

# Enable Apache rewrite module for Laravel routing
RUN a2enmod rewrite

# Set the working directory inside the container
WORKDIR /var/www/html

# Copy all project files into the container
COPY . /var/www/html

# Update Apache configuration to use the Laravel public folder
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Change Apache to listen on Render’s dynamic port
RUN sed -i 's/80/${PORT}/g' /etc/apache2/sites-available/000-default.conf

# Expose Render port
EXPOSE 10000

# Start Apache
CMD ["apache2-foreground"]
