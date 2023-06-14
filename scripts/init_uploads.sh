#!/bin/bash
if [ ! -d "/var/www/html/web3/app/publico/uploads" ]; then
  mkdir -p /var/www/html/web3/app/publico/uploads
  chown -R www-data:www-data /var/www/html/web3/app/publico/uploads
fi


echo "127.0.0.1   meu-site.local" > /etc/hosts