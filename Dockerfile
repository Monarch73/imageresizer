FROM trafex/php-nginx
USER root
ADD install.sh /tmp/install.sh
COPY --chown=nobody php/ /var/www/html/
RUN sh /tmp/install.sh
USER nobody 
