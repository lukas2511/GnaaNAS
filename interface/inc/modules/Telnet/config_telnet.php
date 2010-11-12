<?php

$basepath="/var/nas/inc/modules/".base64_decode($_SERVER['argv'][1])."/.simpleconfig/".base64_decode($_SERVER['argv'][2]);

$config=glob($basepath."/*");

foreach($config as $file){
        $option=basename($file);
	$value=strtr(file_get_contents($file),array("\n"=>"","\r"=>"","\b"=>""," "=>""));
	if($option==base64_decode($_SERVER['argv'][2]).".service"){
		if($value!="/bin/true"){
			exec("cp /usr/sbin/in.telnetd.enabled /usr/sbin/in.telnetd");
		}else{
			exec("cp /usr/sbin/in.telnetd.disabled /usr/sbin/in.telnetd");
		}
		exec("chmod +x /usr/sbin/in.telnetd");
	}
}

?>
