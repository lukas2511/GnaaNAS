<?php

$filestoread=unserialize(base64_decode($_SERVER['argv'][1]));
$files=array();

foreach($filestoread as $file){
	if(file_exists($file)){
		$cont=file_get_contents($file);
		if(substr($cont,-1)=="\n") $cont=substr($cont,0,-1);
		$files[$file]=$cont;
	}
}

echo base64_encode(serialize($files));

?>
