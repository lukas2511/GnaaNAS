<?php

$file=base64_decode($_SERVER['argv']['1']);

echo is_dir($file);

?>
