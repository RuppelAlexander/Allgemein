#!/bin/bash
Scriptdir=$PWD
cd "$(dirname "$0")"
cd ./utilities
./stack.sh down
cd ..
cd $Scriptdir