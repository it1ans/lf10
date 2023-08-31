FROM nginx:1.23

COPY default.conf /etc/nginx/conf.d/

RUN groupadd -g 1000 app
RUN useradd -d /home/app -s /bin/bash -u 1000 -g 1000 app
RUN mkdir /home/app
RUN chown -R app:app /home/app

RUN printf "\n\app ALL=(ALL) NOPASSWD: ALL\n\n" >> /etc/sudoers

RUN sed -i -E "s/user\s+nginx;/user  app;/g" /etc/nginx/nginx.conf

RUN touch /var/run/nginx.pid \
 && chown -R app:app /var/run/nginx.pid /var/cache/nginx /var/log/nginx

USER app:app

WORKDIR /var/www/project
