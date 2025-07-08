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
        showLogst="SELECT * FROM performance_schema.global_status WHERE variable_name = 'innodb_redo_log_enabled';"
        set_Dislog="ALTER INSTANCE DISABLE INNODB REDO_LOG;"
        echo set Default collation for server
        docker exec -it $dockerMysqlContainer mysql -h localhost -u root -proot -e "$set_Dislog" | grep -v "mysql: \[Warning\]"
        echo restart sugarct-mysql:
        docker  restart $SQL_CONTAINER
        sleep 2
	echo "INNODB REDO_LOG Status"
        docker exec -it $dockerMysqlContainer mysql -h localhost -u root -proot -e "$showLogst" | grep -v "mysql: \[Warning\]"

else
    echo The stack is not running, please start the stack first
fi
