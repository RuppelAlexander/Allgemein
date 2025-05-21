#!/bin/bash
# Include Config variables
Scriptdir=$PWD
cd "$(dirname "$0")"
cd ../data/rector/RectorToolkit
docker run --rm --interactive --tty \
--volume $PWD:/app \
composer update
cd $Scriptdir
