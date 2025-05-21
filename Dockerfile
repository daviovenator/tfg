FROM php:8.1-apache

# Copia el código a la carpeta web del contenedor
COPY . /var/www/html/

# Habilita mod_rewrite si lo necesitas
RUN a2enmod rewrite
