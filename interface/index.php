<?php

/*
	GnaaNAS
	Written by Lukas2511
	Idea by Lukas2511 and virtualmarc

	You are an Idiot.
*/

session_start();

include "inc/config.php";
include "inc/login.php";
include "inc/functions.php";

if($_GET['p']=="Home/Modules"){
	$modules_source=unserialize(file_get_contents("http://gnaanas.xxpro.net/packages.php"));
	if(isset($_GET['r'])){
		$name=strtr($_GET['r'],array(".."=>""));
		exec("sudo rm -r inc/modules/".escapeshellcmd($name));
	}

	if(isset($_GET['i'])){
		$name=$_GET['i'];
		if(isset($modules_source[$name])){
			exec("mkdir -p /var/nas/tmp");
			file_put_contents("/var/nas/tmp/module_".$name.".tar",file_get_contents($modules_source[$name]['file']));
			exec("mkdir -p /var/nas/inc/modules/".escapeshellcmd($name));
			exec("tar xf /var/nas/tmp/module_".escapeshellcmd($name).".tar -C /var/nas/inc/modules/".escapeshellcmd($name));
			$modules[$name]=$modules_source[$name];
		}
	}
}

include "inc/pages.php";

if(isset($_GET['p'])){
	$curpage=explode("/",$_GET['p'],2);
	if(isset($curpage[1])) $subpage=$curpage[1]; else $subpage=$curpage[0];
	$curpage=$curpage[0];
}else{
	$curpage="Home";
	$subpage="Dashboard";
}

if(isset($content[$curpage][$subpage])){
	// Do nothing..
}elseif(!isset($pages[$curpage]) && isset($_GET['p'])){
	$curpage="Home";
	$subpage="Dashboard";
}elseif(isset($_GET['p'])){
	$found=0;
	foreach($pages as $page){
		if(isset($page[$subpage])){
			$found=1;
		}
	}
	if(!$found){
		$curpage="Home";
		$subpage="Dashboard";
	}
}

if(isset($_USER)){
	include "inc/content.php";
}

?>
