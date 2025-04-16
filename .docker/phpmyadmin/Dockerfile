# Use phpMyAdmin as the base image
FROM phpmyadmin/phpmyadmin

# Configure PHP settings for file uploads and execution limits
RUN touch /usr/local/etc/php/conf.d/uploads.ini \
    && echo "upload_max_filesize = 2024M" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "post_max_size = 2024M" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "memory_limit = 2024M" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "max_execution_time = 30000" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "max_input_time = 30000" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "max_file_uploads = 1000" >> /usr/local/etc/php/conf.d/uploads.ini
