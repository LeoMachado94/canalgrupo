FROM nginx

RUN set -x \
    && mkdir -m 777 /src \
    && mkdir -m 777 /src/public

ADD ./docker/dev/nginx.conf /etc/nginx/conf.d/default.conf
