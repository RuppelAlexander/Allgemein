#!/bin/bash
# check if the stack is running
running=`docker ps | grep sugar13-mysql | wc -l`
SQL_CONTAINER=$(docker ps | grep sugar13-mysql | awk '{print $1}')
if [ $running -gt 0 ]
then
    # running
        set_collation_server="SET PERSIST collation_server = 'utf8mb4_general_ci';"
        echo set Default collation for server
        docker exec -it sugar13-mysql mysql -h localhost -u root -proot -e "$set_collation_server" | grep -v "mysql: \[Warning\]"
        docker restart $SQL_CONTAINER
else
    echo The stack is not running, please start the stack first
fi
