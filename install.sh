#!/bin/sh
#insert "client_max_body_size 100M;" to /etc/nginx/conf.d/default.conf file 
sed -i '/server_name/i client_max_body_size 100M;' /etc/nginx/conf.d/default.conf
sed -i '/Date/i upload_max_filesize = 1000M;' /etc/php83/conf.d/custom.ini
sed -i '/Date/i post_max_size = 1000M;' /etc/php83/conf.d/custom.ini
sed -i '/Date/i memory_limit = -1;' /etc/php83/conf.d/custom.ini
apk add --no-cache php83-zip
apk add --no-cache libzip-dev
chown -R nobody:nobody /var/www/html

