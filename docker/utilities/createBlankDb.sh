#!/bin/bash

source "../stacks/sugar/.env"
dockerBasename=$BASE_NAME
STACKFILE="../stacks/sugar/sugar.yml"
dockerWebContainer=$dockerBasename-web1
dockerCronContainer=$dockerBasename-cron
dockerMysqlContainer=$dockerBasename-mysql
dockerPermissionContainer=$dockerBasename-permissions
dockerElasticContainer=$dockerBasename-elasticsearch

# check if the stack is running
running=`docker ps | grep $dockerMysqlContainer | wc -l`
SQL_CONTAINER=$(docker ps | grep $dockerMysqlContainer | awk '{print $1}')
# check if rsync is installed
if [ `command -v rsync | grep rsync | wc -l` -eq 0 ]
then
    echo Please install \"rsync\" before running the restore command
    exit 1
fi

if [ $running -gt 0 ]
then
    # running
        showdefaultcol="SHOW VARIABLES LIKE 'collation_server'"
        set_collation_server="SET PERSIST collation_server = 'utf8mb4_general_ci';"
        dropDb="DROP DATABASE IF EXISTS sugar;"
        createsql="CREATE DATABASE sugar CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;"
        echo Remove Old database
        docker exec -i $dockerMysqlContainer mysql -h localhost -u root -proot -e "$dropDb" | grep -v "mysql: \[Warning\]"
        echo set Default collation for server
        docker exec -i $dockerMysqlContainer mysql -h localhost -u root -proot -e "$set_collation_server" | grep -v "mysql: \[Warning\]"
        echo restart $dockerMysqlContainer:
        docker  restart $SQL_CONTAINER
        sleep 2
        echo Create Empty database
        docker exec -i $dockerMysqlContainer mysql -h localhost -u root -proot -e "$createsql" | grep -v "mysql: \[Warning\]"
        echo collation_server is:
        docker exec -i $dockerMysqlContainer mysql -h localhost -u root -proot -e "$showdefaultcol" | grep -v "mysql: \[Warning\]"
else
    echo The stack is not running, please start the stack first
fi
