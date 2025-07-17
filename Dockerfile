# Gunakan image PHP + Apache
FROM php:8.1-apache

# Salin semua file ke dalam container
COPY . /var/www/html/

# Ubah permission (opsional)
RUN chmod -R 755 /var/www/html/

# Aktifkan modul rewrite (kalau pakai .htaccess)
RUN a2enmod rewrite
