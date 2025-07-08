#!/bin/bash
Scriptdir=$PWD
cd "$(dirname "$0")"
cp ./configs/appffolder/* ../data/app/
cd $Scriptdir
