#!/bin/sh
#insert "client_max_body_size 100M;" to /etc/nginx/conf.d/default.conf file 
sed -i '/server_name/i client_max_body_size 100M;' /etc/nginx/conf.d/default.conf
apk add --no-cache php83-zip
apk add --no-cache libzip-dev

