FROM nginx

ARG DOCKER_UID
ARG DOCKER_GID
RUN groupadd -g $DOCKER_GID app
RUN useradd -u $DOCKER_UID -g $DOCKER_GID -d /var/www/app app

COPY ./conf/default.conf /etc/nginx/conf.d/default.conf
COPY ./conf/nginx.conf   /etc/nginx/nginx.conf
