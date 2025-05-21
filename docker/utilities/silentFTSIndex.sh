#!/bin/bash

# check if the stack is running
# Include Config variables
source "../stacks/sugar/.env"
dockerBasename=$BASE_NAME
dockerCronContainer=$dockerBasename-cron
dockerWebContainer=$dockerBasename-web1
dockerPermissionContainer=$dockerBasename-permissions
RUNNING=`docker ps | grep $dockerCronContainer | wc -l`
RUNNING2=`docker ps | grep $dockerElasticContainer | wc -l`

if [ $RUNNING -gt 0 ] 
then
    if [ $RUNNING -gt 0 ] 
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
       # ElIndices="curl -f 'http://$dockerElasticContainer:9200/_cat/indices' -Ss | awk '{print \$3}'"
        for index in $(./runcli.sh $dockerBasename "curl -f 'http://$dockerElasticContainer:9200/_cat/indices' -Ss | awk '{print \$3}'")
        do
             echo "Remove $index"
             ElIndex="curl -f -XDELETE 'http://$dockerElasticContainer:9200/$index' -Ss -o /dev/null"
            ./runcli.sh $dockerBasename $ElIndex
        done
        echo Elastic Clean Done
        ./runcli.sh $dockerBasename "php -f ./silentFTSIndex.php"
        
    else
        echo The stack needs to be running to initialise the transient storages 
    fi
else
    echo The stack needs to be running to initialise the transient storages 
fi