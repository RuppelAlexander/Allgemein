#! /bin/bash
# Include Config variables
source "../stacks/sugar/.env"
dockerBasename=$BASE_NAME
dockerWebContainer=$dockerBasename-web1
dockerCronContainer=$dockerBasename-cron
dockerMysqlContainer=$dockerBasename-mysql
dockerPermissionContainer=$dockerBasename-permissions
dockerElasticContainer=$dockerBasename-elasticsearch

PHP_CONTAINER=$(docker ps | grep $dockerWebContainer | awk '{print $1}')

getMyIP ()
{
    local _ip _myip _line _nl=$'\n'
    while IFS=$': \t' read -a _line ;do
        [ -z "${_line%inet}" ] &&
           _ip=${_line[${#_line[1]}>4?1:2]} &&
           [ "${_ip#127.0.0.1}" ] && _myip=$_ip
      done< <(LANG=C /sbin/ifconfig)
    printf ${1+-v} $1 "%s${_nl:0:$[${#1}>0?0:1]}" $_myip
}

xdebug_status ()
{
    echo 'xDebug status'
    docker exec -i $PHP_CONTAINER bash -c 'php -v'
}

xdebug_start ()
{
    echo 'Start xDebug'

    # Uncomment line with xdebug extension, thus enabling it
    ON_CMD="sed -i 's/^;zend_extension=/zend_extension=/g' \
                    //etc/php/8.2/mods-available/xdebug.ini"
    docker exec -i $PHP_CONTAINER bash -c "${ON_CMD}"

    if [[ "$1" == "change-ip" ]]; then
        # Grab IP address of eth0
        IP=$(getMyIP)
        # Change IP address for parameter xdebug.client_host
        IP_CMD="sed -i 's/^xdebug.client_host=.*/xdebug.client_host=$IP/g' \
                     /etc/php/8.2/mods-available/xdebug.ini"
        docker exec -i $PHP_CONTAINER bash -c "${IP_CMD}"
        echo "New IP of client_host: $IP"
    fi

    docker restart $PHP_CONTAINER
    docker exec -i $PHP_CONTAINER bash -c 'php -v'
    echo "Zugriff per:"
    echo "http://docker.local:${SUGAR_PORT}"
}

xdebug_stop ()
{
    echo 'Stop xDebug'

    # Comment out xdebug extension line
    OFF_CMD="sed -i 's/^zend_extension=/;zend_extension=/g' /etc/php/8.2/mods-available/xdebug.ini"

    docker exec -i $PHP_CONTAINER bash -c "${OFF_CMD}"
    docker restart $PHP_CONTAINER
    docker exec -i $PHP_CONTAINER bash -c 'php -v'
    echo "Zugriff per:"
    echo "http://docker.local:${SUGAR_PORT}"
}

case $1 in
    stop|STOP)
        xdebug_stop
        ;;
    start|START)
        xdebug_start "$2"
        ;;
    status|STATUS)
        xdebug_status
        ;;
    *)
        echo "xDebug [Stop | Start | Status] in the ${PHP_FPM_CONTAINER} container."
        echo "xDebug must have already been installed."
        echo "Usage:"
        echo "  .php/xdebug stop|start|status"

esac

exit 1
