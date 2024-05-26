FROM trafex/php-nginx
USER root
ADD install.sh /tmp/install.sh
RUN sh /tmp/install.sh
USER nobody 
