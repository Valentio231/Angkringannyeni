# Menggunakan image PHP dengan Apache
FROM php:8.1-apache

# Salin semua file proyek ke direktori kerja di dalam container
COPY . /var/www/html/

# Aktifkan mod_rewrite Apache jika perlu
RUN a2enmod rewrite

# Set izin yang tepat (opsional)
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Expose port 80
EXPOSE 80
