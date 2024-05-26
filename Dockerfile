FROM trafex/php-nginx
ADD install.sh /tmp/install.sh
RUN sh /tmp/install.sh
