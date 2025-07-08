#!/bin/bash
Scriptdir=$PWD
cd "$(dirname "$0")"
cd ./utilities
./xdebug.sh status
cd ..
cd $Scriptdir
