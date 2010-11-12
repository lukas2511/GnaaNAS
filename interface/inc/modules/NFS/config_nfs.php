<?php

$basepath="/var/nas/inc/modules/".base64_decode($_SERVER['argv'][1])."/.simpleconfig/".base64_decode($_SERVER['argv'][2]);

$lines="";
$shares=glob($basepath."/*.share");
foreach($shares as $share){
	$share=unserialize(file_get_contents($share));
	$lines.=$share['path'].' '.$share['network'].'('.$share['options'].')'."\n";
}

file_put_contents("/etc/exports",$lines);
exec("exportfs -rv");

?>
