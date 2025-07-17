# Gunakan image PHP dengan Apache
FROM php:8.1-apache

# Salin isi folder proyek ke dalam direktori Apache
COPY . /var/www/html/

# Aktifkan modul rewrite (jika diperlukan, misalnya untuk .htaccess)
RUN a2enmod rewrite

# Ubah port default Apache dari 80 ke 8080
RUN sed -i 's/80/8080/g' /etc/apache2/ports.conf /etc/apache2/sites-available/000-default.conf

# Buka port 8080
EXPOSE 8080
