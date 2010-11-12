<?php

$basepath="/var/nas/inc/modules/".base64_decode($_SERVER['argv'][1])."/.simpleconfig/".base64_decode($_SERVER['argv'][2]);

foreach(glob($basepath."/*") as $file){
	file_put_contents("/etc/pure-ftpd/conf/".basename($file),file_get_contents($file));
}

?>
