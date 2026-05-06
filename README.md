# Laravel Application Deployment Guide

This document outlines the steps to deploy a Laravel project on a server.

---

## Prerequisites

- A Linux-based server (Ubuntu, CentOS, Debian, etc.)
- PHP >= 8.2 (depending on Laravel version)
- Composer installed on the server
- Web server: Apache / Nginx / OpenLiteSpeed, etc.
- MySQL / MariaDB or any other supported database
- Git (optional)
- SSL certificate (optional but recommended)

---

## Step 1: Prepare the Server

1. SSH into your server.

2. Install required packages:

    ```bash
    sudo apt update
    sudo apt install php php-cli php-fpm php-mysql php-zip php-mbstring php-xml php-curl php-bcmath unzip curl git -y
    ```

3. Install Composer (if not already installed):

    ```bash
    curl -sS https://getcomposer.org/installer | php
    sudo mv composer.phar /usr/local/bin/composer
    composer --version
    ```

---

## Step 2: Setup Project

1. Clone your Laravel project or upload files:

    ```bash
    cd /var/www
    git clone https://github.com/your-username/your-laravel-project.git
    cd your-laravel-project
    ```

2. Install composer dependencies:

    ```bash
    composer install --no-dev --optimize-autoloader
    ```

3. Copy and configure the `.env` file:

    ```bash
    cp .env.example .env
    ```

    Then update the `.env` file with your database and other settings.

4. Generate the application key:

    ```bash
    php artisan key:generate
    ```

5. Run database migrations:

    ```bash
    php artisan migrate --force
    ```

---

## Step 3: Set File Permissions

```bash
sudo chown -R www-data:www-data /var/www/your-laravel-project/storage /var/www/your-laravel-project/bootstrap/cache
sudo chmod -R 775 /var/www/your-laravel-project/storage /var/www/your-laravel-project/bootstrap/cache
