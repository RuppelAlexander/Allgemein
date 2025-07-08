#!/bin/bash
Scriptdir=$PWD
cd "$(dirname "$0")"
if [ -f "./stacks/sugar/.env" ]; then
	source "./stacks/sugar/.env"
else
	echo "env FILE Not Found."
fi

dockerBasename=$BASE_NAME
dockerCronContainer=$dockerBasename-cron
# check if the stack is running
running=`docker ps | grep $dockerCronContainer | wc -l`
if [ $running -gt 0 ]
then
   docker exec -it  $dockerCronContainer /bin/bash
else
   echo The stack needs to be running before executing a cli command
fi
cd $Scriptdir
