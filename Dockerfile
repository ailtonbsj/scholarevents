FROM php:7.2-apache

RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini

COPY scholarevents /var/www/html/
RUN chmod 777 -R /var/www/html/ 

EXPOSE 8080

RUN apt-get -q update && apt-get -qy install netcat
ADD https://raw.githubusercontent.com/eficode/wait-for/master/wait-for /bin/wait-for
RUN chmod +x /bin/wait-for

COPY deploy.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/deploy.sh

RUN echo "deploy.sh &" > /usr/local/bin/async-deploy.sh && chmod +x /usr/local/bin/async-deploy.sh
CMD async-deploy.sh && docker-php-entrypoint apache2-foreground