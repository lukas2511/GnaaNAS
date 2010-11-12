<?php

$basepath="/var/nas/inc/modules/".base64_decode($_SERVER['argv'][1])."/.simpleconfig/".base64_decode($_SERVER['argv'][2]);

$configfile="/etc/transmission-daemon/settings.json";

if(strtr(file_get_contents($basepath."/".base64_decode($_SERVER['argv'][2]).".service"),array("\n"=>"","\r"=>"","\b"=>""," "))!="/bin/true"){
	exec(file_get_contents($basepath."/".base64_decode($_SERVER['argv'][2]).".service")." stop");
}

$json=file_get_contents($configfile);
$json=json_decode($json,true);

if(file_get_contents($basepath."/Interface")=="true"){
	$json['rpc-enabled']=true;
}else{
	$json['rpc-enabled']=false;
}

$json['rpc-username']="admin";
$json['rpc-port']=(int) file_get_contents($basepath."/IPort");
$json['peer-port']=(int) file_get_contents($basepath."/Port");

$password=file_get_contents($basepath."/Password");
if(!empty($password)){
	$json['rpc-password']=$password;
	$json['rpc-authentication-required']=true;
}else{
	$json['rpc-authentication-required']=false;
}

$json['rpc-whitelist-enabled']=false;
$json['ratio-limit']="0.0";
$json['ratio-limit-enabled']=true;
$json['incomplete-dir']=file_get_contents($basepath."/Dir")."/.Incomplete";
$json['incomplete-dir-enabled']=true;
$json['download-dir']=file_get_contents($basepath."/Dir");
$json['blocklist-enabled']=true;
$json['blocklist-updates-enabled']=true;

if(file_get_contents($basepath."/Down")>0){
	$json['speed-limit-down']=(int) file_get_contents($basepath."/Down");
	$json['speed-limit-down-enabled']=true;
}else{
	$json['speed-limit-down-enabled']=false;
}

if(file_get_contents($basepath."/Up")>0){
	$json['speed-limit-up']=(int) file_get_contents($basepath."/Up");
	$json['speed-limit-up-enabled']=true;
}else{
	$json['speed-limit-up-enabled']=false;
}

$json['umask']=0;

$json=json_encode($json);
$replace[]="/^{/";
$with[]="{\n";
$replace[]="/(\\\")([0-9a-z\-_]+)(\\\"\:)(\\\")?([\\:\\{\\}0-9a-z\-_\,\\/\\\\\\.]+)?(\\\")?(\,)/i";
$with[]="    $1$2$3 $4$5$6$7 \n";
$replace[]="/\\\\\\//";
$with[]="/";
$replace[]="/\\n(\\\")([0-9a-z\-_]+)(\\\"\:)(\\\")?([\\:\\{\\}0-9a-z\-_\,\\/\\\\\\.]+)?(\\\")?(\,)?}/";
$with[]="\n    $1$2$3 $4$5$6$7\n}\n";
$config=preg_replace($replace,$with,$json);
file_put_contents($configfile,$config);

if(strtr(file_get_contents($basepath."/".base64_decode($_SERVER['argv'][2]).".service"),array("\n"=>"","\r"=>"","\b"=>""," "))!="/bin/true"){
	exec(file_get_contents($basepath."/".base64_decode($_SERVER['argv'][2]).".service")." start");
}

?>
