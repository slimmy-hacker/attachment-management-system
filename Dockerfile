FROM php:8.3-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev libzip-dev zip unzip nginx \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy project files
COPY . .

# Set permissions for storage and cache
RUN chown -R www-data:www-data storage bootstrap/cache

# Install PHP dependencies without dev packages
RUN composer install --no-dev --optimize-autoloader --no-interaction --ignore-platform-reqs

# Create nginx config with preserved $ variables and using Render's dynamic port
RUN cat <<'EOF' > /etc/nginx/sites-available/default
server {
    listen ${PORT};
    root /var/www/html/public;
    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include fastcgi_params;
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }

    location ~ /\.ht {
        deny all;
    }
}
EOF

# Enable the nginx config
RUN ln -sf /etc/nginx/sites-available/default /etc/nginx/sites-enabled/default

# Make sure start.sh is executable
RUN chmod +x /var/www/html/start.sh

# Expose port 80 (optional, Render uses $PORT)
EXPOSE 80

# Start PHP-FPM and nginx
CMD ["/var/www/html/start.sh"]
