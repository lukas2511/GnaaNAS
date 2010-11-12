<?php

$title="WebServer";
$startstopscript="/etc/init.d/lighttpd";
$configscript="config_webserver.php";
$configname="webserver";

$autorestart=1;

$simpleconfig=array(
	"Port" => array( "Default is 80.", "text" , "Port" , "80" ),
	"PHP" => array( "Enable PHP" , "checkbox" , "PHP" , "yes" , "no" , "no" ),
	"SSL" => array( "Enable SSL" , "checkbox" , "SSL" , "yes" , "no" , "no" ),
	"SSL Port" => array( "Default is 443.", "text" , "sslport" , "443" ),
	"SSL Only" => array( "Disable Non-SSL" , "checkbox" , "SSLonly" , "yes" , "no" , "no" ),

	"Directory" => array ( "Where are the files?" , "text" , "Dir" , "/mnt" ),
	"Directory List" => array ( "Directory Listing" , "checkbox" , "Indexes" , "yes" , "no" , "yes" ),
	"Username" => array ( "Which user should the server be run under?" , "text" , "User" , "www-data" ),
	"lighttpd.conf" => array ( "Additional Configuration" , "textarea" , "Extra" , "# Here you can place your additional configuration" ),
);

include "lib/simpleconfig.php";

?>
