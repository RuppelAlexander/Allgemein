#!/bin/bash
# Initialize our own variables
OPTIND=1         # Reset in case getopts has been used previously in the shell.
version='1.0.0'
author='DontG'
pdate=$(date '+%Y-%m-%d %H:%M:%S')
padir="Packete"
suname=""
supath="data/app/sugar"
while getopts "h?p:n:d:v:b:z" opt; do
    case "$opt" in
    d) supath=$OPTARG
       ;;
    h|\?)  echo "Usage: $0  -d [sugar path]"
        exit 0
        ;;
    esac
done
if [ -z "$supath" ]; then
 echo "-d Kein Sugar Pfad"
 exit 1;
fi


cd "$(dirname "$0")"

Scriptdir=$PWD

echo "use folder $supath"
cd "$supath"
#echo $(CreateManifestBase "$ModKey" "$version" "$author" "$name" "$description")

Pattern="\*[[:blank:]]+Main Program[[:blank:]]+:[[:blank:]]+(.*,[[:blank:]]*|.*;[[:blank:]]*|).*([[:blank:]]?[,|;]?.*$)"
echo "grep for files $suname"

filelist=$(grep  --exclude-dir={upload,cache,upgrades} --exclude='*.php_*' --exclude='*.ext.php' -ER .  -e "$Pattern")
echo "Search for Main Programs:"
if [ -d "$Scriptdir/$padir/$suname" ]; then
  rm -r  "$Scriptdir/$padir/$suname"
fi
myArray=()
while read row; do 
  if [[ "$row" == *":"* ]]; then
    nam=$(echo $row|cut -d ':' -f 3|sed -e 's/^[[:space:]]*//' -e 's/[[:space:]]*$//')
    if [[ $nam == *","* ]]; then
      IFS=',' read -a mrowlist <<< "$nam"
      for mname in "${mrowlist[@]}"
      do
          trmnam=$(echo -e "${mname}" | tr -d '[:space:]')
          if  [[ ! ${myArray[@]} =~ $trmnam ]]
          then
            echo "$trmnam"
            myArray+=("$trmnam")
          fi

      done
    else
      if  [[ ! ${myArray[@]} =~ nam ]]
      then
        echo "$nam"
        myArray+=("$nam")
      fi
    fi
  fi
done <<< "$filelist"

cd $Scriptdir

for Key in "${myArray[@]}"
do
   echo "Found $Key"
   ./ExtractMainProgram.sh -p "$Key" -d data/app/sugar
done
