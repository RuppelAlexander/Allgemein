#!/bin/bash
# Initialize our own variables
OPTIND=1         # Reset in case getopts has been used previously in the shell.
version='1.0.0'
author='xxxx'
pdate=$(date '+%Y-%m-%d %H:%M:%S')
padir="Pakete"
suname=""
supath=""
while getopts "h?p:n:d:v:b:z" opt; do
    case "$opt" in
    p) suname=$OPTARG
        ;;
    d) supath=$OPTARG
       ;;
    v) version=$OPTARG
       ;;
    b) mname=$OPTARG
       ;;
    z) padir=$OPTARG
       ;;
    h|\?)  echo "Usage: $0  -p [main programm name] -d [ sugar path]"
           echo "optional -b [manifest  name] -v [manifest version] -z [Destination Name]"
        exit 0
        ;;
    esac
done
if [ -z "$suname" ]; then
 echo "Kein main programm name"
 exit 1;
fi
if [ -z "$supath" ]; then
 echo "Kein Sugar Pfad"
 exit 1;
fi


if [ -z "$mname" ]; then
 mname="$suname";
fi


Scriptdir=$PWD
ManifestLines=()
Mtext=$(cat << EOM
\$manifest = array(
    'acceptable_sugar_versions' => array('regex_matches' => array( "14\.*","13\.*",)),
    'acceptable_sugar_flavors' => array("ULT","ENT","PRO","CORP",),
    'readme' => '',
    'key' => '$suname',
    'author' => '$author',
    'name' => '$mname',
    'description' => '',
    'icon' => '',
    'is_uninstallable' => true,
    'remove_tables' => 'prompt',
    'uninstall_before_upgrade' => false,
    'published_date' => '$pdate',
    'type' => 'module',
    'version' => '$version',
);
EOM
)
cd "$supath"
echo "-----"
echo "Extract $suname"
Pattern="\*[[:blank:]]+Main Program[[:blank:]]+:[[:blank:]]+(.*,[[:blank:]]*|.*;[[:blank:]]*|)$suname([[:blank:]]?[,|;]?.*$)"
#echo $Pattern
ISCDEV=0
if [ -d ./ISC_DEV ]; then
  ISCDEV=1
  filelist=$(grep  --exclude-dir={upload,cache,upgrades,ISC_DEV}  --exclude='*.php_*' --exclude='*.ext.php' -ER .  -e "$Pattern")
  else
  filelist=$(grep  --exclude-dir={upload,cache,upgrades}  --exclude='*.php_*' --exclude='*.ext.php' -ER .  -e "$Pattern")
fi

if [ -d "$Scriptdir/$padir/$suname" ]; then
  rm -r  "$Scriptdir/$padir/$suname"
fi
 ManifestLines+=("\$installdefs = array(")
 ManifestLines+=("\t'id' => '$suname',")
si=1;
if [ $ISCDEV -eq 1 ]; then
  Scriptfilelist=$(grep  -ER ./ISC_DEV  -e "$Pattern")
else
  Scriptfilelist=()
fi
Sclen=${#Scriptfilelist[@]}
if [ "$Sclen" -ne 0 ]; then
ManifestLines+=("\t'post_execute' => array(");
	while read Scriptrow; do
		name=$(echo $Scriptrow|cut -d ':' -f 1)
		fpath=${name:2}
		mfolder=$(echo $Scriptrow|cut -d ':' -f 1|cut -d '/' -f 3)
		nameFile=$(echo $Scriptrow|cut -d ':' -f 1|cut -d '/' -f 4)
		ScriptFolder=${mfolder}
		fFile=${nameFile}
		if [ "$ScriptFolder" = "Scripts_postexecute" ]; then
			mkdir -p "$Scriptdir/$padir/$suname/$result/Scripts"
			cp $fpath "$Scriptdir/$padir/$suname/Scripts/$nameFile"
			ManifestLines+=("\t'<basepath>/Scripts/$nameFile'");
			
		fi
	ManifestLines+=("\t),");	
	done <<< "$Scriptfilelist"
 fi
 
 ManifestLines+=("\t'copy' => array(");
i=1;
while read row; do
  name=$(echo $row|cut -d ':' -f 1)
  fpath=${name:2}
  
  result=$(dirname "$fpath")
  dFile=$(echo $(basename "$fpath"))
  mkdir -p "$Scriptdir/$padir/$suname/$result"
  cp $fpath "$Scriptdir/$padir/$suname/$result"
 
  echo "File $result/$dFile"
  ManifestLines+=( "\t\tarray(")
  ManifestLines+=( "\t\t\t'from' =>'<basepath>/$fpath',")
  ManifestLines+=( "\t\t\t'to' =>'$fpath',")
  ManifestLines+=( "\t\t),")

  filelist+=($name)
  i=$(($i+1));
done <<< "$filelist"
ManifestLines+=( "\t),")
ManifestLines+=( ");")
echo "-----"
cd  "$Scriptdir/$padir/$suname"
Authors=$(grep -ER . -e "\*[[:blank:]]+Author[[:blank:]]+:[[:blank:]]+([\w|,| |.]*)" | awk -F ':' '{print $3}')

IFS=, eval 'Asep="${Authors[*]}"'
PjAuthor=$(printf '%s\n' "${Asep[@]}")

#echo "Author: $PjAuthor"
echo -e " <?php " > "$Scriptdir/$padir/$suname/manifest.php"
echo -e "$Mtext" >> "$Scriptdir/$padir/$suname/manifest.php"
for id in "${!ManifestLines[@]}"
do
  echo -e " ${ManifestLines[$id]}" >> "$Scriptdir/$padir/$suname/manifest.php" 
done
cd $Scriptdir
