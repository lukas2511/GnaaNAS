<?php

function root_file_exists($file){
	$file=base64_encode($file);
	if(exec("sudo php /var/nas/lib/cmd/file_exists.php '".$file."'")){
		return true;
	}else{
		return false;
	}
}

function root_is_dir($file){
	$file=base64_encode($file);
	if(exec("sudo php /var/nas/lib/cmd/is_dir.php '".$file."'")){
		return true;
	}else{
		return false;
	}
}

function root_file_get_contents($file){
	$file=base64_encode($file);
	return exec("sudo php /var/nas/lib/cmd/file_get_contents.php '".$file."'");
}

function root_file_put_contents($file,$cont){
	$file=base64_encode($file);
	$cont=base64_encode($cont);
	return exec("sudo php /var/nas/lib/cmd/file_put_contents.php '".$file."' '".$cont."'");
}

function root_batch_get($files){
	$files=base64_encode(serialize($files));
	return unserialize(base64_decode(exec("sudo php /var/nas/lib/cmd/batch_get.php ".$files)));
}

?>
