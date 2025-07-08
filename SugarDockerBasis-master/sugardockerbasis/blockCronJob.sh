#!/bin/bash
Scriptdir=$PWD
cd "$(dirname "$0")"
cd ./utilities
./xCron.sh stop
cd ..
cd $Scriptdir