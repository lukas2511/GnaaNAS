<?php

$file=base64_decode($_SERVER['argv']['1']);

echo file_get_contents($file);

?>
