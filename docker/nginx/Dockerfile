FROM nginx:stable

MAINTAINER Murilo B Delefrate <murilobd@gmail.com>

# Copy nginx configs
ADD nginx.conf /etc/nginx/nginx.conf

# Create required directories
RUN mkdir -p /etc/nginx/sites-available && \
    mkdir -p /etc/nginx/sites-enabled && \
    mkdir -p /var/log/nginx

# Disable The Default Nginx Site
RUN rm -rf /etc/nginx/sites-available/default
RUN rm -rf /etc/nginx/sites-enabled/default

# Copy sites do nginx
ADD ./api.mybudget.dev /etc/nginx/sites-available/api.mybudget.dev
ADD ./app.mybudget.dev /etc/nginx/sites-available/app.mybudget.dev

ADD ./default.conf /etc/nginx/conf.d/default.conf

ADD ./expires.conf /etc/nginx/expires.conf

# Create symlink
RUN ln -s /etc/nginx/sites-available/api.mybudget.dev /etc/nginx/sites-enabled/api.mybudget.dev
RUN ln -s /etc/nginx/sites-available/app.mybudget.dev /etc/nginx/sites-enabled/app.mybudget.dev

# forward request and error logs to docker log collector
RUN ln -sf /dev/stdout /var/log/nginx/access.log \
    && ln -sf /dev/stderr /var/log/nginx/error.log \
    && ln -sf /dev/stderr /var/log/nginx/api.mybudget-error.log \
    && ln -sf /dev/stderr /var/log/nginx/app.mybudget-error.log

# change zonetime to Brazil
RUN cp /usr/share/zoneinfo/Brazil/East /etc/localtime

# Copy ENTRYPOINT
ADD ./webserver.sh /opt/bin/webserver.sh
RUN chmod u=rwx /opt/bin/webserver.sh

# When launch the container, run this file
ENTRYPOINT ["/opt/bin/webserver.sh"]