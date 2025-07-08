#!/bin/bash
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
dockerWebContainer=$dockerBasename-web1
dockerCronContainer=$dockerBasename-cron
dockerMysqlContainer=$dockerBasename-mysql
dockerPermissionContainer=$dockerBasename-permissions
dockerElasticContainer=$dockerBasename-elasticsearch

RUNNING=`docker ps | grep $dockerWebContainer | wc -l`

if [ $RUNNING -gt 0 ]
then
    # enter the repo's root directory
    REPO="$( dirname ${BASH_SOURCE[0]} )/../../"
    cd $REPO
    # running
    # if it is our repo
    if [ -f '.gitignore' ] && [ -d 'data' ] && [ -f 'data/app/sugar/install.php' ]
    then
        # generate silent installer config
        ./utilities/build/generateinstallconfigs.sh $dockerBasename

        # run silent installer
        echo Running installation, please wait...
        curl -f 'http://docker.local/sugar/install.php?goto=SilentInstall&cli=true' -Ss -o /dev/null
        echo  
        echo Installation completed!
        echo 
        echo You can now access the instance on your browser with http://docker.local/sugar

        # post installation initialisation for specific actions (eg: creating test users etc)
        cp ./utilities/build/initsystem.php ./data/app/
        echo Executing script ./data/app/initsystem.php
        ./utilities/runcli.sh $dockerBasename "php -f ../initsystem.php"
        echo Done
    else
        echo The command needs to be executed from within the clone of the repository, containing a valid Sugar system within sugar\'s directory
    fi
else
    echo The stack needs to be running to complete Sugar\'s installation
fi
