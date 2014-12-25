FROM      tutum/lamp:latest

RUN       rm -rf /app
COPY      . /app

RUN       mkdir -p /app/src/www/assets && \
          chown -R www-data /app/src

EXPOSE    80 3306

CMD       ["./run.sh"]
