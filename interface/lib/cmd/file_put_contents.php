<?php

$file=base64_decode($_SERVER['argv']['1']);
$cont=base64_decode($_SERVER['argv']['2']);

file_put_contents($file,$cont);

?>
