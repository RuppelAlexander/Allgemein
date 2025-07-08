#!/bin/bash
# Include Config variables
source "../stacks/sugar/.env"
dockerBasename=$BASE_NAME
dockerMysqlContainer=$dockerBasename-mysql

    # check if the stack is running
    running=`docker ps | grep $dockerMysqlContainer | wc -l`

    if [ $running -gt 0 ]
    then
         REPO="$( dirname ${BASH_SOURCE[0]} )/../"
        cd $REPO
        BACKUP_DIR="./dbdump"
                #mysqldump -h docker.local -u root -proot --order-by-primary --single-transaction -Q --opt --skip-extended-insert sugar > $BACKUP_DIR/sugar.sql
                # running mysqldump on the mysql container instead
                docker exec -it $dockerMysqlContainer mysqldump -h localhost -u root -proot --order-by-primary --single-transaction -Q --opt --skip-extended-insert --no-data sugar | grep -v "mysqldump: \[Warning\]" > $BACKUP_DIR/sugar_structur.sql
    docker exec -it $dockerMysqlContainer mysqldump -h localhost -u root -proot --order-by-primary --single-transaction -Q --opt --skip-extended-insert sugar acl_actions acl_fields acl_roles acl_roles_actions acl_roles_users config currencies custom_fields eapm expressions fields_meta_data relationships roles roles_modules roles_users team_memberships team_notices team_sets team_sets_modules team_sets_teams teams upgrade_history user_preferences users schedulers| grep -v "mysqldump: \[Warning\]" > $BACKUP_DIR/sugar_data.sql

	fi
