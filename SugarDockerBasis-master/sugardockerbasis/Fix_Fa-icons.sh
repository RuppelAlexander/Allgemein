#!/bin/bash
# Initialize our own variables
Scriptdir=$PWD
cd "$(dirname "$0")"
extfolder="custom"
pext=""
basepath="data/app/sugar"
padir="fa-icon_fix"
while getopts "h?d:f" opt; do
    case "$opt" in
    d) basepath=$OPTARG
       ;;
    h|\?)  echo "Usage: $0  -d [ sugar path]"
        exit 0
        ;;
    esac
done


suname="BadIcons$pext"
suname2="FixedIcons$pext"
suname3="HBSIcons$pext"
supath="$basepath$pext"
Scriptdir=$PWD
echo "-----"
echo "Extract Files contain Icons Search:"
Pattern="'icon' => 'fa-"
echo  "Pattern: $Pattern  Path: $supath"
echo $supath
cd $supath
filelist=$(grep --include="*.php"  --exclude-dir={upload,cache,upgrade,upgrades,ISC_DEV}  --exclude='*.ext.php'   -ER .  -e "$Pattern" | awk '{print $1}' | sort -u )
echo "${Scriptdir:?}/$padir/$suname"


if [ -d "${Scriptdir:?}/$padir/$suname" ]; then
  rm -r  "${Scriptdir:?}/$padir/$suname"
fi
if [ -d "${Scriptdir:?}/$padir/$suname2" ]; then
  rm -r  "${Scriptdir:?}/$padir/$suname2"
fi
if [ -d "${Scriptdir:?}/$padir/$suname3" ]; then
  rm -r  "${Scriptdir:?}/$padir/$suname3"
fi
if [ ! -d "${Scriptdir:?}/$padir" ]; then
  mkdir  "${Scriptdir:?}/$padir"
  echo "create Dir  ${Scriptdir:?}/$padir"
 
fi


si=1;
i=1;
	while read row; do
	  name=$(echo $row|cut -d ':' -f 1)
#echo "Full: $name"
	  fpath=${name:2}
	  result=$(dirname "$fpath")
#echo "fpath: $fpath"
#echo "result: $result"
#echo "${name: -4}"

	if [ "${name: -4}" == ".php" ]; then
	  mkdir -p "$Scriptdir/$padir/$suname/$result"
	  mkdir -p "$Scriptdir/$padir/$suname2/$result"
      echo "$fpath"
	  cp $fpath "$Scriptdir/$padir/$suname/$result"
	  cp $fpath "$Scriptdir/$padir/$suname2/$result"

	  sed -i "s/'icon' => 'fa-list-ul/'icon' => 'sicon-list/g"  "$Scriptdir/$padir/$suname2/$fpath" 
	  sed -i "s/'icon' => 'fa-plus/'icon' => 'sicon-plus/g" "$Scriptdir/$padir/$suname2/$fpath"
	  sed -i "s/'icon' => 'fa-arrow-circle-o-up/'icon' => 'sicon-upload/g" "$Scriptdir/$padir/$suname2/$fpath"
	  sed -i "s/'icon' => 'fa-eye/'icon' => 'sicon-preview/g" "$Scriptdir/$padir/$suname2/$fpath"
	  sed -i "s/'icon' => 'fa-pencil/'icon' => 'sicon-edit/g" "$Scriptdir/$padir/$suname2/$fpath"
	  sed -i "s/'icon' => 'fa-chain-broken/'icon' => 'sicon-unlink/g" "$Scriptdir/$padir/$suname2/$fpath"
	  sed -i "s/'icon' => 'fa-times-circle/'icon' => 'sicon-close/g" "$Scriptdir/$padir/$suname2/$fpath"  
	  sed -i "s/'icon' => 'fa-trash-o/'icon' => 'sicon-trash/g" "$Scriptdir/$padir/$suname2/$fpath"  
	  sed -i "s/'icon' => 'fa-bars/'icon' => 'sicon-list-view/g" "$Scriptdir/$padir/$suname2/$fpath"  
	  sed -i "s/'icon' => 'fa-table/'icon' => 'sicon-list-view/g" "$Scriptdir/$padir/$suname2/$fpath"  
	  sed -i "s/'icon' => 'fa-clock-o/'icon' => 'sicon-clock/g" "$Scriptdir/$padir/$suname2/$fpath"  
	  sed -i "s/'icon' => 'fa-link/'icon' => 'sicon-link/g" "$Scriptdir/$padir/$suname2/$fpath" 
	  sed -i "s/'icon' => 'fa-phone/'icon' => 'sicon-phone/g" "$Scriptdir/$padir/$suname2/$fpath"  
	  sed -i "s/'icon' => 'fa-calendar/'icon' => 'sicon-calendar/g" "$Scriptdir/$padir/$suname2/$fpath"
	  sed -i "s/'icon' => 'fa-cog/'icon' => 'sicon-settings/g" "$Scriptdir/$padir/$suname2/$fpath"
	  sed -i "s/'icon' => 'fa-road/'icon' => 'sicon-car-front/g" "$Scriptdir/$padir/$suname2/$fpath"
	  i=$(($i+1));
	  fi
	done <<< "$filelist"

echo "php Done"
echo "-------------------------------------------------"
Pattern2=" class[ ]?=['|\"]fa fa-"

filelist2=$(grep --include="*.hbs"  --exclude-dir={upload,cache,upgrades,ISC_DEV} -ER .  -e "$Pattern2" | awk '{print $1}' | sort -u)

while read row2; do
echo $row2
  name2=$(echo $row2|cut -d ':' -f 1)
  fpath2=${name2:2}
  result2=$(dirname "$fpath2")
  
 if [ "${name2: -4}" == ".hbs" ]; then
    mkdir -p "$Scriptdir/$padir/$suname/$result2"
    mkdir -p "$Scriptdir/$padir/$suname3/$result2"
    cp $fpath2 "$Scriptdir/$padir/$suname/$result2"
    cp $fpath2 "$Scriptdir/$padir/$suname3/$result2"
    i=$(($i+1));
  fi
done <<< "$filelist2"
echo "hbs Done"

echo "bitte HBS Files Kontrollieren, Hbs werden nicht automatisch gefixt!"
cd $Scriptdir
