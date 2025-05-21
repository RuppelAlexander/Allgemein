#!/bin/bash
# Initialize our own variables
Scriptdir=$PWD
cd "$(dirname "$0")"
suname="BadIcons"
suname2="FixedIcons"
supath="data/app/sugar"
while getopts "h?p:n:d:v:b:z" opt; do
    case "$opt" in
    d) supath=$OPTARG
       ;;
    h|\?)  echo "Usage: $0  -p [main programm name] -d [ sugar path]"
           echo "optional -b [manifest  name] -v [manifest version] -z [Destination Name]"
        exit 0
        ;;
    esac
done
Scriptdir=$PWD
echo "-----"
echo "Extract Old Icons"
Pattern="'icon' => 'fa-"
echo $Pattern
cd $supath
filelist=$(grep  --exclude-dir={upload,cache,upgrades,ISC_DEV}  --exclude='*.ext.php' -ER .  -e "$Pattern")

if [ -d "$Scriptdir/$padir/$suname" ]; then
  rm -r  "$Scriptdir/$padir/$suname"
fi
if [ -d "$Scriptdir/$padir/$suname2" ]; then
  rm -r  "$Scriptdir/$padir/$suname2"
fi

si=1;

i=1;
while read row; do
  name=$(echo $row|cut -d ':' -f 1)
  fpath=${name:2}
  result=$(dirname "$fpath")
echo "$fpath"
  mkdir -p "$Scriptdir/$padir/$suname/$result"
  mkdir -p "$Scriptdir/$padir/$suname2/$result"
  cp $fpath "$Scriptdir/$padir/$suname/$result"
  cp $fpath "$Scriptdir/$padir/$suname2/$result"
  
  echo "File $Scriptdir/$padir/$suname/$result"
  i=$(($i+1));
done <<< "$filelist"

cd $Scriptdir