#! /bin/bash

# Grab full name of php container\
Scriptdir=$PWD
cd "$(dirname "$0")"
source "../stacks/sugar/.env"
dockerBasename=$BASE_NAME
dockerCronContainer=$dockerBasename-cron

PHP_CONTAINER=$(docker ps | grep $dockerCronContainer | awk '{print $1}')


Cron_stop ()
{
    echo 'Cron flag Stop'
    ON_CMD="touch /var/www/html/sugar/cron_pause"
    docker exec -i $PHP_CONTAINER bash -c "${ON_CMD}"

}

Cron_start ()
{
    echo 'Cron Allow'
    ON_CMD="rm /var/www/html/sugar/cron_pause"
    docker exec -i $PHP_CONTAINER bash -c "${ON_CMD}"
}

echo "use $dockerCronContainer"

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
