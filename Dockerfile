# Usando a imagem base PHP com Apache
FROM php:8.2-apache

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql\
    && pecl install redis \
    && docker-php-ext-enable redis

# Instalar o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Configurar o diretório de trabalho
WORKDIR /var/www

# Criar as pastas storage e bootstrap/cache
RUN mkdir -p storage bootstrap/cache

# Configurar permissões para as pastas necessárias
RUN chmod -R 775 storage bootstrap/cache

# Copiar configuração do Apache
COPY ./apache/vhost.conf /etc/apache2/sites-available/000-default.conf

# Ativar mod_rewrite
RUN a2enmod rewrite
