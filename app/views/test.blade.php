<?php









$user = User::find(1)->first();
echo '<img src="data:image/gif;base64,' . getLabel($user) . '" />';
//var_dump($user);
//var_dump(getLabel($user));

$user = Auth::user();
var_dump($user['id']);


?>
