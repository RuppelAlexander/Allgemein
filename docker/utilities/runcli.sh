#!/bin/bash
if [ -z ${BASE_NAME} ]; then
    if [ -f "./stacks/sugar/.env" ]; then
        source "./stacks/sugar/.env"
    else 
        if [ -f "../stacks/sugar/.env" ]; then
            source "../stacks/sugar/.env"
        else 
            echo "env FILE Not Found."
        fi
    fi
fi
dockerBasename=$BASE_NAME
dockerCronContainer=$dockerBasename-cron
shift
if [ $# -eq 0 ]
then
    echo Provide the command\(s\) to run as arguments
else
    # check if the stack is running
    running=`docker ps | grep $dockerCronContainer | wc -l`

    if [ $running -gt 0 ]
    then
        # enter the repo's root directory
        REPO="$( dirname ${BASH_SOURCE[0]} )/../"
        cd $REPO
        # running
        # if it is our repo
        if [ -f '.gitignore' ] && [ -d 'data' ]
        then
            user_command="cd /var/www/html/sugar && $@"
          
            docker exec $dockerCronContainer bash -c "$user_command"
        else
            echo The command needs to be executed from within the clone of the repository
        fi
    else
        echo The stack needs to be running before executing a cli command
    fi
fi
