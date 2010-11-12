<?php

$basepath="/var/nas/inc/modules/".base64_decode($_SERVER['argv'][1])."/.simpleconfig/".base64_decode($_SERVER['argv'][2]);

$lines="";
if(file_get_contents($basepath."/PHP")=="yes"){
	$php=1;
}else{
	$php=0;
}
if(file_get_contents($basepath."/SSL")=="yes"){
	$ssl=1;
	if(!file_exists("/etc/lighttpd/ssl/server.pem")){
		exec("mkdir -p /etc/lighttpd/ssl");
		exec("cd /etc/lighttpd/ssl; openssl req -new -x509 -keyout server.pem -out server.pem -days 365 -nodes -batch");
	}
	$sslport=file_get_contents($basepath."/sslport");
	if(!is_numeric($sslport) || $sslport==file_get_contents($basepath."/Port")){
		$sslport=443;
	}
	if(file_get_contents($basepath."/SSLonly")=="yes"){
		$sslonly=1;
	}else{
		$sslonly=0;
	}
}else{
	$ssl=0;
}
$lines.='server.modules += ( "mod_access" )'."\n";
if($php){
	$lines.='server.modules += ( "mod_fastcgi" )'."\n";
}
$lines.='server.document-root = "'.file_get_contents($basepath."/Dir").'/"'."\n";
$lines.='server.upload-dirs = ( "/var/cache/lighttpd/uploads" )'."\n";
$lines.='server.errorlog = "/var/log/lighttpd/error.log"'."\n";
$lines.='index-file.names = ( "index.php", "index.htm", "index.html" )'."\n";
$lines.='static-file.exclude-extensions = ( ".php", ".pl", ".fcgi" )'."\n";
$lines.='server.pid-file = "/var/run/lighttpd.pid"'."\n";
$lines.='server.username = "'.file_get_contents($basepath."/User").'"'."\n";
$lines.='server.groupname = "www-data"'."\n";
$lines.='include_shell "/usr/share/lighttpd/create-mime.assign.pl"'."\n";
$lines.='server.port = '.file_get_contents($basepath."/Port")."\n";
if($php){
	$lines.='fastcgi.server = ( ".php" => (("bin-path" => "/usr/bin/php5-cgi","socket" => "/tmp/php.socket")))'."\n";
}
if(file_get_contents($basepath."/Indexes")=="yes"){
	$lines.='dir-listing.encoding = "utf-8"'."\n";
	$lines.='server.dir-listing = "enable"'."\n";
}
$lines.=file_get_contents($basepath."/Extra")."\n";
if($ssl){
	if(!$sslonly){
		$lines.='$SERVER["socket"] == ":'.$sslport.'" {'."\n";
	}
	$lines.='ssl.engine = "enable"'."\n";
	$lines.='ssl.pemfile = "/etc/lighttpd/ssl/server.pem"'."\n";
	if(!$sslonly){
		$lines.='}'."\n";
	}
}

file_put_contents("/etc/lighttpd/lighttpd.conf",$lines);
exec("chown -R ".file_get_contents($basepath."/User")." /var/*/lighttpd -R");
