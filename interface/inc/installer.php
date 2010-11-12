<?php

$module=$modpages[$curpage][$subpage];

$lockfile="/var/nas/inc/modules/".$module."/.install_lock";
$finishfile="/var/nas/inc/installed/".$module.".installed";
$installscript="/var/nas/inc/modules/".$module."/install.sh";

if(isset($_POST['action']) && $_POST['action']=="install" && !file_exists($lockfile) && !file_exists($finishfile)){
	exec("sudo mkdir -p /var/nas/inc/installed");
	exec("sudo touch '".$lockfile."'");
	exec("sudo screen -dmS install".rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9)." sh -c \"sh '".$installscript."'; touch '".$finishfile."'\"");
}

echo '<h3>Module Installation</h3>';
if(file_exists($lockfile) && !file_exists($finishfile)){
	echo "<p style='margin-left:10px'>This module is being installed right now.. please be patient this could take some time..</p>";
}elseif(!file_exists($finishfile)){
	echo "<p style='margin-left:10px'>It seems that this module is not installed right now.. do you wish to install it now ?<br /><br />";
	echo '<form style="margin-left:10px" action="" method="post"><input type="hidden" name="action" value="install" /><input type="submit" value="Install" /></form>';
}else{
	echo "<p style='margin-left:10px'>The module has been installed!</p>";
}

?>
