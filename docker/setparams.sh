#! /bin/bash
# Include Config variables
Scriptdir=$PWD
cd "$(dirname "$0")"
source "./stacks/sugar/.env"
Paramfile="./data/app/params.php"
echo "<?php" >$Paramfile
echo "\$STACK_NAME='$STACK_NAME';" >> $Paramfile
echo "\$BASE_NAME='$BASE_NAME';" >>$Paramfile
echo "\$SUGAR_PORT='$SUGAR_PORT';" >>$Paramfile
echo "\$MAILHOG_PORT='$MAILHOG_PORT';" >>$Paramfile
echo "\$MYADMIN_PORT='$MYADMIN_PORT';" >>$Paramfile
echo "\$ELVU_PORT='$ELVU_PORT';" >>$Paramfile
echo "\$ELASTIC_PORT='$ELASTIC_PORT';" >>$Paramfile
cat $Paramfile;
cd $Scriptdir