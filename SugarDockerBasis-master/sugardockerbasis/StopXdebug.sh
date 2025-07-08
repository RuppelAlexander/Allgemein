#!/bin/bash
Scriptdir=$PWD
cd "$(dirname "$0")"
cd ./utilities
./xdebug.sh stop
cd ..
cd $Scriptdir