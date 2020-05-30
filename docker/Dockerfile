FROM webdevops/php-apache:7.2
LABEL maintainer="Anteneh Gebeyaw <antenehgeb@gmail.com>"

RUN docker-service-disable cron

ENV WEB_DOCUMENT_ROOT /var/www/html

# setup supervisord killer
COPY supervisor.d/kill_supervisor.py /opt/docker/bin/usr-bin
COPY supervisor.d/killer.conf /opt/docker/etc/supervisor.d

# virtual host config
COPY site.conf /opt/docker/etc/httpd/vhost.common.d

# PHP settings
# see here for more https://dockerfile.readthedocs.io/en/latest/content/DockerImages/dockerfiles/php-apache.html
ENV PHP_DATE_TIMEZONE "Africa/Addis_Ababa"
ENV fpm.pool.pm.max_children 48
ENV fpm.pool.pm.max_requests 500
ENV fpm.pool.pm.status_path /status

# replace shell with bash so we can source files
RUN rm /bin/sh && ln -s /bin/bash /bin/sh
