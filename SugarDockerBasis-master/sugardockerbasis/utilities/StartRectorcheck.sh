#!/bin/bash
Scriptdir=$PWD
cd "$(dirname "$0")"
RUNNING=`docker ps | grep rector | wc -l`
docker-compose -f ./stacks/rector/rector.yml up --build
echo Workfolder ist here:
echo "cd data/rector/RectorToolkit/working/daily"
cd $Scriptdir
