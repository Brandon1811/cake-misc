#!/bin/bash
bin/cake Setup.MaintenanceMode activate

echo "### CODE ###";
git pull origin

composer install --prefer-dist --optimize-autoloader --no-interaction

echo "### FILE SYSTEM PERMISSIONS ###";

mkdir -p ./tmp
mkdir -p ./logs

sudo chown {{your_username_here}}:www-data -R .

HTTPDUSER=`ps aux | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1`
sudo setfacl -R -m u:${HTTPDUSER}:rwx tmp
sudo setfacl -R -d -m u:${HTTPDUSER}:rwx tmp
sudo setfacl -R -m u:${HTTPDUSER}:rwx logs
sudo setfacl -R -d -m u:${HTTPDUSER}:rwx logs
sudo chmod u+x bin/cake

echo "### DB MIGRATION ###";
# bin/cake migrations migrate --no-lock -p Josegonzalez/CakeQueuesadilla
bin/cake migrations migrate --no-lock -p Captcha
bin/cake migrations migrate --no-lock -p Muffin/Tokenize
bin/cake migrations migrate --no-lock
bin/cake migrations seed


echo "### ASSETS ###";
bin/cake asset_compress build
gulp images
gulp compressCss
gulp compressJs

echo "### CLEANUP ###";
bin/cake cache clearAll
bin/cake schema_cache clear

echo "### CACHE WARMING ###";
bin/cake orm_cache build

echo "### FINAL PERMISSIONS ###"
sudo chown {{your_username_here}}:www-data -R .
HTTPDUSER=`ps aux | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1`
sudo setfacl -R -m u:${HTTPDUSER}:rwx tmp
sudo setfacl -R -d -m u:${HTTPDUSER}:rwx tmp
sudo setfacl -R -m u:${HTTPDUSER}:rwx logs
sudo setfacl -R -d -m u:${HTTPDUSER}:rwx logs

echo "### DONE ###";
bin/cake Setup.MaintenanceMode deactivate
