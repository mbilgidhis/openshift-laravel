#!/bin/bash
set -e 

echo "Migrating database 'php artisan migrate --force'..."
##php artisan migrate --force
php artisan reset

echo "Install NPM"
sudo yum install nodejs -y
sudo yum install npm -y
npm install
npm run dev


