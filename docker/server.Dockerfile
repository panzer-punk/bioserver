FROM openjdk:17.0.2-jdk-slim-bullseye

ARG SERVER_PATH
ARG RUN_FILE_PATH

RUN apt-get update && apt-get install -y wget

RUN wget https://dev.mysql.com/get/Downloads/Connector-J/mysql-connector-j_8.0.32-1debian11_all.deb \
    && dpkg --install mysql-connector-j_8.0.32-1debian11_all.deb

COPY --chown=www-data:www-data $SERVER_PATH /var/www/bioserver
COPY --chown=www-data:www-data $RUN_FILE_PATH /var/www/run.sh

WORKDIR /var/www

RUN javac -cp /usr/share/java/mysql-connector-j-8.0.32.jar:. ./bioserver/*.java

RUN mkdir -p bin/bioserver \
    && mv bioserver/*.class bin/bioserver \
    && mkdir lib \
    && cp /usr/share/java/mysql-connector-j-8.0.32.jar lib/mysql-connector.jar 

RUN apt-get install -y lsof iputils-ping

CMD [ "sh", "-c", "/var/www/run.sh" ]



