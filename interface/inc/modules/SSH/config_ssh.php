<?php

$basepath="/var/nas/inc/modules/".base64_decode($_SERVER['argv'][1])."/.simpleconfig/".base64_decode($_SERVER['argv'][2]);

$config=glob($basepath."/*");

$lines="";

$lines.="Protocol 2\n";
$lines.="HostKey /etc/ssh/ssh_host_rsa_key\n";
$lines.="HostKey /etc/ssh/ssh_host_dsa_key\n";
$lines.="UsePrivilegeSeparation yes\n";
$lines.="KeyRegenerationInterval 3600\n";
$lines.="ServerKeyBits 768\n";
$lines.="SyslogFacility AUTH\n";
$lines.="LogLevel INFO\n";
$lines.="LoginGraceTime 120\n";
$lines.="StrictModes yes\n";
$lines.="RSAAuthentication yes\n";
$lines.="IgnoreRhosts yes\n";
$lines.="RhostsRSAAuthentication no\n";
$lines.="HostbasedAuthentication no\n";
$lines.="ChallengeResponseAuthentication no\n";
$lines.="X11DisplayOffset 10\n";
$lines.="PrintMotd no\n";
$lines.="PrintLastLog yes\n";
$lines.="TCPKeepAlive yes\n";
$lines.="Banner ".$basepath."/Banner\n";
$lines.="AcceptEnv LANG LC_*\n";
$lines.="Subsystem sftp /usr/lib/openssh/sftp-server\n";
$lines.="UsePAM yes\n";

foreach($config as $file){
        $option=basename($file);
        $value=file_get_contents($file);
	if($option!=base64_decode($_SERVER['argv'][2]).".service" && $option!="Banner"){
	        if(substr($value,-1)!="\n") $value.="\n";
	        $line=$option." ".$value;
	        $lines.=$line;
	}elseif($option=="Banner"){
		if(substr($value,-1)!="\n") file_put_contents($file,$value."\n");
	}
}

file_put_contents("/etc/ssh/sshd_config",$lines);

?>
