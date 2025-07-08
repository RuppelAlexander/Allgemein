#!/bin/bash
# Include Config variables
source "../stacks/sugar/.env"
dockerBasename=$BASE_NAME
dockerCronContainer=$dockerBasename-cron
dockerWebContainer=$dockerBasename-web1
dockerPermissionContainer=$dockerBasename-permissions
dockerMysqlContainer=$dockerBasename-mysql
dockerPermissionContainer=$dockerBasename-permissions
dockerElasticContainer=$dockerBasename-elasticsearch
    # check if the stack is running
    running=`docker ps | grep $dockerMysqlContainer | wc -l`

    if [ $running -gt 0 ]
    then
         REPO="$( dirname ${BASH_SOURCE[0]} )/../"
        cd $REPO
        BACKUP_DIR="./dbdump"
                #mysqldump -h docker.local -u root -proot --order-by-primary --single-transaction -Q --opt --skip-extended-insert sugar > $BACKUP_DIR/sugar.sql
                # running mysqldump on the mysql container instead
                docker exec -it $dockerMysqlContainer mysqldump -h localhost -u root -proot --order-by-primary --single-transaction -Q --opt --skip-extended-insert sugar | grep -v "mysqldump: \[Warning\]" > $BACKUP_DIR/sugar.sql
    fi
