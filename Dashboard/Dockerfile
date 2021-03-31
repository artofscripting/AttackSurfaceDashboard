FROM debian
WORKDIR /code
RUN apt update
RUN apt install dos2unix -y

RUN apt install apache2 -y
RUN apt -y install lsb-release apt-transport-https ca-certificates php libapache2-mod-php
RUN service apache2 restart
RUN apt install php-curl -y

COPY html /var/www/html
CMD apachectl -D FOREGROUND
