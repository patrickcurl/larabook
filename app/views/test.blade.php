<?php









$user = User::find(2);
//file_put_contents('test123.gif', base64_decode(getLabel($user, 2.5)));
//$filename = 'test123.gif';
//$source = imagecreatefromgif($filename);
//$label =  imagerotate($source, 90, 0);
//echo imagejpeg($label);
$label = getLabel($user, 2.5);
echo var_dump($label);


echo '<img src="data:image/gif;base64,' . $label . '" height="392" and width="651"/>';
//var_dump($user);
//var_dump(getLabel($user));
//echo '<br /><img src="data:image/gif;base64,895UIGJ89XCASDVIGFUISDFNKLFSDANUI43UIT34IONSDFKHG89GUKGJNGKDJFKDJDGKJDKFSDU089REUTDRKJOEIOUTERIJREIKGRJIGOWEJIEJIEGJGRIOEJGRIGJIODJGFIODFJSIOUDFIOGDFUGDF890ERUTRIOGTJRDIOOGJGIOSDFJGIOJGIOJIOGFUGJIOGU90E8T9TRFIRWEU90WERU90WU90WTU90WUT09WEUTWRJGKSDFJGIOSDFJGOISDFJGIOSJSD" />';

//$user = Auth::user();
//var_dump($user['id']);
