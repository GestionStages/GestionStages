#!/bin/sh

# Rappatriement depuis git de la branch
cd /var/www/html
git pull origin dev --rebase

# Installation des dependencies
composer install

# Maj de la BD
php bin/console doctrine:schema:update --force

# Suppression des cache
php bin/console cache:clear --env=dev
php bin/console cache:clear --env=prod

# Reassignation des droits
chown -hR www-data:www-data /var/www/html
