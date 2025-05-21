#!/bin/bash
Scriptdir=$PWD
ManifestLines=()
version='1.0.0'
author='DontG'
pdate=$(date '+%Y-%m-%d %H:%M:%S')
Mtext=$(cat << EOM
\$manifest = array(
    'acceptable_sugar_versions' => array('regex_matches' => array('14\\.\*','13\\.\*')),
    'acceptable_sugar_flavors' => array( 0 => 'ENT', 1 => 'ULT', ),
    'readme' => '',
    'key' => '${1}',
    'author' => '$author',
    'name' => '${1}',
    'icon' => '',
    'is_uninstallable' => true,
    'description' => '',
    'published_date' => '$pdate',
    'type' => 'module',
    'version' => '$version',
);
EOM
)
cd data/app/sugar
#echo $(CreateManifestBase "$ModKey" "$version" "$author" "$name" "$description")

Pattern="\*[[:blank:]]+Main Program[[:blank:]]+:[[:blank:]]+(.*,[[:blank:]]*|.*;[[:blank:]]*|)${1}([[:blank:]]*,[[:blank:]]*|[[:blank:]]*;[[:blank:]]*|[[:blank:]]*$)"

#grep --exclude-dir={upload,cache,upgrades} --exclude='*.ext.php' -ER .  -e "$Pattern"

filelist=$(grep  --exclude-dir={upload,cache,upgrades} --exclude='*.ext.php' -ER .  -e "$Pattern")

i=1;

 ManifestLines+=("\$installdefs = array(")
 ManifestLines+=("\t'id' => '${1}',") 
 ManifestLines+=("\t'copy' => array(");

while read row; do 
  name=$(echo $row|cut -d ':' -f 1)
  fpath=${name:2}
  result=$(dirname "$fpath")
  mkdir -p "$Scriptdir/Pakete/${1}/$result"
  cp $fpath "$Scriptdir/Pakete/${1}/$result"
#  echo "File $i. $name Key: $key"
  ManifestLines+=( "\t\tarray(")
  ManifestLines+=( "\t\t\t'from' =>'<basepath>/$fpath',")
  ManifestLines+=( "\t\t\t'to' =>'$fpath',")
  ManifestLines+=( "\t\t),")
  
  filelist+=($name)
  i=$(($i+1)); 
done <<< "$filelist"
ManifestLines+=( "\t),")
ManifestLines+=( ");")
echo -e " <?php " > "$Scriptdir/Pakete/${1}/manifest.php"
 echo -e "$Mtext" >> "$Scriptdir/Pakete/${1}/manifest.php"
for id in "${!ManifestLines[@]}"
do
  echo -e " ${ManifestLines[$id]}" >> "$Scriptdir/Pakete/${1}/manifest.php" 
done

cd $Scriptdir