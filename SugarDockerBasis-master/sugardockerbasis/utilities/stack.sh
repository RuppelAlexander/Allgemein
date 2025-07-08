#!/bin/bash
# Include Config variables
source "../stacks/sugar/.env"
dockerBasename=$BASE_NAME
STACKFILE="../stacks/sugar/sugar.yml"
dockerWebContainer=$dockerBasename-web1
dockerCronContainer=$dockerBasename-cron
dockerMysqlContainer=$dockerBasename-mysql
dockerPermissionContainer=$dockerBasename-permissions
dockerElasticContainer=$dockerBasename-elasticsearch

Paramfile="../data/app/params.php"
ELVUParamfile="../data/elasticvue/default_clusters.json"


# if it is our repo, and the source exists, and the destination does not
if [ -f '../.gitignore' ] && [ -d '../data' ] && [ ! -z $STACKFILE ] && [ -f $STACKFILE ]
then
if [[ ! -e "../data/app" ]]; then
    mkdir -p "../data/app"
elif [[ ! -d "../data/app" ]]; then
    echo "data/app already exists but is not a directory" 1>&2
fi
if [[ ! -e "../data/elasticvue" ]]; then
    mkdir -p "../data/elasticvue"
elif [[ ! -d "../data/elasticvue" ]]; then
    echo "data/app already exists but is not a directory" 1>&2
fi
    # Write Param file
	echo "<?php" >$Paramfile
	echo "\$STACK_NAME='$STACK_NAME';" >> $Paramfile
	echo "\$BASE_NAME='$BASE_NAME';" >>$Paramfile
	echo "\$SUGAR_PORT='$SUGAR_PORT';" >>$Paramfile
	echo "\$MAILHOG_PORT='$MAILHOG_PORT';" >>$Paramfile
	echo "\$MYADMIN_PORT='$MYADMIN_PORT';" >>$Paramfile
	echo "\$ELVU_PORT='$ELVU_PORT';" >>$Paramfile
	echo "\$ELASTIC_PORT='$ELASTIC_PORT';" >>$Paramfile
	
	echo "[{\"name\": \"default cluster\", \"uri\": \"http://docker.local:$ELASTIC_PORT\"}]" > $ELVUParamfile

    # check if the stack is running
    RUNNING=`docker ps | grep $dockerWebContainer | wc -l`
    if [ $RUNNING -gt 0 ] && [ $1 == 'up' ]
    then
        echo "Stack Läuft bereits Bitte erst herunterfahren"
        echo "Container Liste:"
        docker ps --format '{{.Names}}' |grep $dockerBasename
    else
        if [ $1 == 'down' ]
        then
            if [ $RUNNING -eq 0 ]
            then
                echo "Stack $STACKFILE Ist nicht aktiv"
            else
                echo "Stack $STACKFILE wird heruntergefahren"
                docker-compose -f $STACKFILE down
                echo "Am Stack Angehängte anonyme Volumes werden entfernt"
                docker-compose -f $STACKFILE rm
                
               RemainINst=`docker ps --format '{{.Names}}' |grep $dockerBasename`
                if [ ! -z $RemainINst ]
                then
                    echo "Nicht kommplett runtergefahren"
                    echo "Container Liste:"
                    docker ps --format '{{.Names}}' |grep $dockerBasename
                fi
                
            fi
        else
            if [ $1 == 'up' ]
            then
                echo "Stack $STACKFILE wird Gestarted"
                docker-compose -f $STACKFILE up -d --build
                echo "Sugar ist gestarted:"
                echo "http://docker.local:${SUGAR_PORT}/sugar"
            else
                echo "The action $1 ist nicht durchführbar"
            fi
        fi

    fi
else
    if [  -z $STACKFILE ]
    then
        echo "Stackfile: nicht Konfiguriert."
     else
        if [ ! -f $STACKFILE ]; then
            echo "Stackfile:  $STACKFILE nicht vorhanden."
        fi
    fi
    
    
    if [ ! -d '../data' ]
    then
        echo Der Folder  \"../data\" darf nicht leer sein
    fi

fi
