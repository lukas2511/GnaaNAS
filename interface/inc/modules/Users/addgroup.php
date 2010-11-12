<?php

$error="";
$groups=array(); exec("cat /etc/group | awk -F ':' '{print $3}'",$groups);

if(isset($_POST['groupname'])){
	if(empty($_POST['groupname']) || !preg_match("/^([a-z0-9]+)$/",$_POST['groupname']) || strlen($_POST['groupname'])<4 || is_array(posix_getgrnam($_POST['groupname']))){
		$error="Invalid Groupname (Must not exist, Must be at least 4 chars long, Must constist of small letters and numbers)<br />";
	}

	if(empty($error)){
		$groupadd="sudo groupadd '".$_POST['groupname']."'";
		exec($groupadd);
		echo '<span style="color:green">Group was added!</span>';
	}
}

echo '<form action="" method="post">';
echo '<h3>Add Group</h3>';
echo '<fieldset>';
if(!empty($error)){
	echo '<p style="color:red">'.$error.'</p>';
}
echo '<p><label>Groupname:</label><input name="groupname" type="text" class="text-long" value="" /></p>';
echo '<input type="submit" value="Save" />';
echo '</fieldset>';
echo '</form>';

?>
