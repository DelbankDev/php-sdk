FROM php:7.2-apache

# Corrigir repositórios do Debian Buster (EOL) para usar o archive.debian.org
RUN echo "deb http://archive.debian.org/debian buster main" > /etc/apt/sources.list \
    && echo "deb http://archive.debian.org/debian-security buster/updates main" >> /etc/apt/sources.list \
    && apt-get -o Acquire::Check-Valid-Until=false update \
    && apt-get install -y \
    git \
    unzip \
    zip \
    && rm -rf /var/lib/apt/lists/*

# Instalar Composer
COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer

# Habilitar mod_rewrite do Apache
RUN a2enmod rewrite

# Definir diretório de trabalho padrão do Apache
WORKDIR /var/www/html

# Ajustar permissões
RUN chown -R www-data:www-data /var/www/html
