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
# enter the repo's root directory
REPO="$( dirname ${BASH_SOURCE[0]} )/../../"
cd $REPO
if [ -f '.gitignore' ] && [ -d 'data' ]
then
    if [ ! -d './data/app/configs' ]
    then
        mkdir -p ./data/app/configs
    else
        rm ./data/app/configs/*.php
    fi
    echo Generate install configs $dockerBasename
    # copy the source config files under the app directory
    sed -i 's/\$mainName=.*\;/\$mainName=\"'$dockerBasename'\"\;/g' ./utilities/configs/install_config.php
    sed -i 's/\$mainName=.*\;/\$mainName=\"'$dockerBasename'\"\;/g' ./utilities/configs/install_config_custom.php
    sed -i 's/\$mainName=.*\;/\$mainName=\"'$dockerBasename'\"\;/g' ./utilities/configs/custominitsystem.php
    sed -i 's/\$mainName=.*\;/\$mainName=\"'$dockerBasename'\"\;/g' ./utilities/configs/config_override_dockerized.php
    sed -i 's/\$mainName=.*\;/\$mainName=\"'$dockerBasename'\"\;/g' ./utilities/configs/config_override_custom.php
    sed -i 's/\$mainName=.*\;/\$mainName=\"'$dockerBasename'\"\;/g' ./utilities/configs/config_override.php
    cp ./utilities/configs/install_config.php ./data/app/configs/
    cp ./utilities/configs/config_override.php ./data/app/configs/

    # copy the custom template only if it does not already exist
    if [ ! -f './data/app/configs/install_config_custom.php' ]
    then
        echo add install_config_custom
      
       
        cp ./utilities/configs/install_config_custom.php ./data/app/configs/
    fi
    
    # copy the custom template only if it does not already exist
    if [ ! -f './data/app/configs/config_override_custom.php' ]
    then
        echo add config_override_custom
        cp ./utilities/configs/config_override_custom.php ./data/app/configs/
    fi
    if [ ! -f './data/app/custominitsystem.php' ]
    then
        echo add custominitsystem
        cp ./utilities/configs/custominitsystem.php ./data/app/
    fi

    # generate the silent installer config
    if [ -d './data/app/sugar' ]
    then
    
        ./utilities/runcli.sh $dockerBasename "php -f ../configs/install_config.php > ./config_si.php"
        echo The silent installer configuration has been deployed into the sugar instance
        ./utilities/runcli.sh $dockerBasename "php -f ../configs/config_override.php > ./config_override.php"
        echo The config override configuration has been deployed into the sugar instance
    else
        echo The sugar directory ./data/app/sugar does not exist. Please make sure all the Sugar files have been extracted on that location
    fi
else
    echo The command needs to be executed from within the clone of the repository
fi
