<?php

$title="Transmission Torrent-Client";
$startstopscript="/etc/init.d/transmission-daemon";
$configscript="config_transmission.php";
$configname="transmission";

$autorestart=1;
$simpleconfig=array(
	"Download Directory" => array( "Where should I save the files?!?" , "text" , "Dir" , "/mnt" ),
	"Enable WebInterface" => array( "Enables the WebInterface of Transmission" , "checkbox" , "Interface" , "true" , "false" , "true" ),
	"WebInterface Port" => array( "Default is 9091" , "text" , "IPort" , "9091" ),
	"WebInterface Password" => array( "Password for WebInterface (username is admin)" , "text" , "Password", "" ),
	"Torrent Port" => array( "Default is 51413." , "text" , "Port" , "51413" ),
	"Upload Limit" => array( "Upload-Limit in kB/s" , "text" , "Up", "0" ),
	"Download Limit" => array( "Download-Limit in kB/s" , "text" , "Down", "0" ),
);

include "lib/simpleconfig.php";

?>
