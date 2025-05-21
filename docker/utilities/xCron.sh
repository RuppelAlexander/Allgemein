#! /bin/bash

# Grab full name of php container\
Scriptdir=$PWD
cd "$(dirname "$0")"
source "../stacks/sugar/.env"
dockerBasename=$BASE_NAME
dockerCronContainer=$dockerBasename-cron

PHP_CONTAINER=$(docker ps | grep dockerCronContainer | awk '{print $1}')



Cron_start ()
{
    echo 'Cron resume'

   docker exec -it $PHP_CONTAINER bash -c "rm  /var/www/html/sugar/cron_pause"
}

Cron_stop ()
{
    echo 'Cron Pause'
    docker exec -it $PHP_CONTAINER bash -c "touch /var/www/html/sugar/cron_pause"
}

case $1 in
    stop|STOP)
        Cron_stop
        ;;
    start|START)
        Cron_start 
        ;;
    *)
        echo "Cron [Stop | Start | ] in the ${PHP_FPM_CONTAINER} container."
        echo "Usage:"
        echo "  .php/xCron stop|start"

esac
cd $Scriptdir
exit 1
