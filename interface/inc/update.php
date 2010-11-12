<?php

if(isset($_POST['action']) && $_POST['action']=="update"){
	exec("sudo sh /var/nas/lib/update.sh");
}

$newversion=strtr(file_get_contents("http://gnaanas.xxpro.net/version.php"),array("\n"=>"","\r"=>""," "=>""));
$version=root_file_get_contents("/etc/nas/version.txt");

if(isset($_POST['action']) && $_POST['action']=="update"){
	echo '<h3>Update completed!</h3>';
	echo '<p style="margin-left:10px">YEAZ!</p>';
}elseif($newversion>$version){
	echo '<h3>Update available</h3>';
	echo '<p style="margin-left:10px">There is an Update available!<br /><br /><form action="" method="post" style="margin-left:10px"><input type="hidden" name="action" value="update" /><input type="submit" value="Update now!" /></form></p>';
}else{
	echo '<h3>No Update :(</h3>';
	echo '<p style="margin-left:10px">You are already running the latest version of GnaaNAS!</p>';
}

?>
