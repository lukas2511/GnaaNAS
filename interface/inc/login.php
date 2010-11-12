<?php

if(isset($_SERVER['PHP_AUTH_USER'])) {
	$user=posix_getpwnam($_SERVER['PHP_AUTH_USER']);
	$shells=explode("\n",file_get_contents("/etc/shells"));
	if(is_array($user) && isset($user['name']) && $user['name']==$_SERVER['PHP_AUTH_USER'] && ($user['uid']=="0" || ($user['uid']>=$minuid && $user['uid']<=$maxuid))){
		if(isset($user['shell']) && in_array($user['shell'],$shells)){
			$hashpw=exec("sudo cat /etc/shadow | grep '".$user['name']."' | awk -F ':' '{print $2}'");
			if(crypt($_SERVER['PHP_AUTH_PW'],$hashpw)==$hashpw){
				$_USER=(object) array("user"=>$_SERVER['PHP_AUTH_USER'],"pass"=>$_SERVER['PHP_AUTH_PW'],"hashpass"=>$hashpw,"shell"=>$user['shell'],"uid"=>$user['uid'],"gid"=>$user['gid']);
			}
		}
	}
}

if(!isset($_USER) || (isset($_GET['p']) && $_GET['p']=="logout" && ($logoutid=$_GET['l']) && !isset($_SESSION['logout'][$logoutid]))){
	if(isset($_GET['p']) && $_GET['p']=="logout" && !isset($_SESSION['logout'][$logoutid])){
		if(!is_array($_SESSION['logout'])) $_SESSION['logout']=array();
		$_SESSION['logout'][$logoutid]="used";
	}
	header('WWW-Authenticate: Basic realm="GnaaNAS Login"');
	header('HTTP/1.0 401 Unauthorized');
	echo '<h1>NOOOOOOOOOOOOOOOOIN!!</h1>';
	exit;
}

?>
