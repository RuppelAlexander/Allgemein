FROM percona/percona-server:8.0 
RUN adduser sugar --disabled-password --disabled-login --gecos ""
RUN chown -R sugar:sugar /var/lib/mysql
WORKDIR "/var/lib/mysql"
USER sugar
COPY config/mysql/docker.cnf /etc/mysql/conf.d/docker.cnf

