#!/bin/bash
# Include Config variables
if [ -z ${BASE_NAME} ]; then
    if [ -f "./stacks/sugar/.env" ]; then
        source "./stacks/sugar/.env"
    else 
        if [ -f "../stacks/sugar/.env" ]; then
            source "../stacks/sugar/.env"
        else 
            if [ -f "../../stacks/sugar/.env" ]; then
                source "../../stacks/sugar/.env"
            else 
                echo "env FILE Not Found."
            fi
        fi
    fi
fi
dockerBasename=$BASE_NAME
STACKFILE="../../stacks/sugar/sugar.yml"
dockerWebContainer=$dockerBasename-web1
dockerCronContainer=$dockerBasename-cron
dockerMysqlContainer=$dockerBasename-mysql
dockerPermissionContainer=$dockerBasename-permissions
dockerElasticContainer=$dockerBasename-elasticsearch

RUNNING=`docker ps | grep $dockerCronContainer | wc -l`

if [ $RUNNING -gt 0 ]
then
    # enter the repo's root directory
    REPO="$( dirname ${BASH_SOURCE[0]} )/../../"
    cd $REPO
    # running
    # if it is our repo
    if [ -f '.gitignore' ] && [ -d 'data/app/sugar' ]
    then
        # fix up permissions
        echo Fixing Sugar permissions, please wait...
        docker restart $dockerPermissionContainer > /dev/null
        while [ `docker ps | grep $dockerPermissionContainer | wc -l` -ne 0 ]; do
            sleep 1
        done 
        echo Done
        # restart sugar-web1
        echo Restarting $dockerWebContainer container, please wait...
        docker restart $dockerWebContainer > /dev/null
        echo Done
        # restart sugar-cron
        echo Restarting $dockerCronContainer container, please wait...
        docker restart $dockerCronContainer > /dev/null
        echo Done
        # clear elastic data
        echo Deleting all previous Elasticsearch indices, please wait...
        for index in $(./utilities/runcli.sh "curl -f 'http://$dockerElasticContainer:9200/_cat/indices' -Ss | awk '{print \$3}'")
        do
            ./utilities/runcli.sh "curl -f -XDELETE 'http://$dockerElasticContainer/$index' -Ss -o /dev/null"
        done
        echo Done
    else
        echo The command needs to be executed from within the clone of the repository
    fi
else
    echo The stack needs to be running to initialise the transient storages 
fi
