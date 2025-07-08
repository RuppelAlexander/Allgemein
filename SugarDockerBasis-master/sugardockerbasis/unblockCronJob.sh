#!/bin/bash
Scriptdir=$PWD
cd "$(dirname "$0")"
cd ./utilities
./xCron.sh start
cd ..
cd $Scriptdir