#!/bin/bash
Scriptdir=$PWD
cd "$(dirname "$0")"
cd ./utilities
./stack.sh up
#./xdebug.sh start
cd $Scriptdir