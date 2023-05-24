FROM php:8.1-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    libzip-dev \
    libonig-dev \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
RUN docker-php-ext-configure gd --with-jpeg=/usr/include/ --with-freetype=/usr/include/
RUN docker-php-ext-install gd

# Install Node.js and npm
RUN curl -sL https://deb.nodesource.com/setup_14.x | bash -
RUN apt-get install -y nodejs

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Fix permissions for npm cache folder
RUN mkdir -p /var/www/.npm && chown -R www-data:www-data /var/www/.npm
RUN chmod -R 775 /var/www/.npm

# Fix permissions for the project directory
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 775 /var/www/html

# Copy existing application directory permissions
COPY --chown=www-data:www-data . /var/www/html

# Change ownership of npm cache folder
USER www-data
RUN chown -R 33:33 "/var/www/.npm"

# Install project dependencies
RUN composer install --no-interaction --no-plugins --no-scripts
RUN npm install
RUN npm install --legacy-peer-deps

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
