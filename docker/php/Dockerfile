FROM php:7.4.9-fpm

# php.ini をコピー
COPY php.ini /usr/local/etc/php/

# 必要な依存関係をインストール
RUN apt update \
  && apt install -y default-mysql-client zlib1g-dev libzip-dev unzip curl gnupg \
  && docker-php-ext-install pdo_mysql zip

# Composerをインストール
RUN curl -sS https://getcomposer.org/installer | php \
  && mv composer.phar /usr/local/bin/composer \
  && composer self-update

# StripeのPHP SDKをインストールするための依存関係をインストール
WORKDIR /var/www

# StripeのPHP SDKをインストール
RUN composer require stripe/stripe-php

# Node.jsとnpmをインストール（Stripe CLIのため）
RUN curl -sL https://deb.nodesource.com/setup_14.x | bash - \
  && apt install -y nodejs

# Stripe CLIをインストール
RUN npm install -g stripe

# コンテナが起動したらbashを実行する
CMD ["php-fpm"]



