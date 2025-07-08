#!/bin/bash

for id in $(docker ps -aq -f status=running )
do
   docker ps --filter "id=$id" --format '{{.ID}} {{.Names}}'
   docker stop $id    
   echo "stop done"
#   docker stop $id
done
