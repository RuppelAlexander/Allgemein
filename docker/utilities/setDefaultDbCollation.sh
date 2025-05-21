#!/bin/bash
# check if the stack is running
source "../stacks/sugar/.env"
dockerBasename=$BASE_NAME
dockerMysqlContainer=$dockerBasename-mysql
running=`docker ps | grep $dockerMysqlContainer | wc -l`
SQL_CONTAINER=$(docker ps | grep $dockerMysqlContainer | awk '{print $1}')
if [ $running -gt 0 ]
then
    # running
        showdefaultcol="SHOW VARIABLES LIKE 'collation_server'"
        set_collation_server="SET PERSIST collation_server = 'utf8mb4_general_ci';"
        echo set Default collation for server
        docker exec -it $dockerMysqlContainer mysql -h localhost -u root -proot -e "$set_collation_server" | grep -v "mysql: \[Warning\]"
        echo restart sugarct-mysql:
        docker  restart $SQL_CONTAINER
        sleep 2
        echo collation_server is:
        docker exec -it $dockerMysqlContainer mysql -h localhost -u root -proot -e "$showdefaultcol" | grep -v "mysql: \[Warning\]"

else
    echo The stack is not running, please start the stack first
fi
