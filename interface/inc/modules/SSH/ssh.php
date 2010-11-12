<?php

$title="SSH";
$startstopscript="/etc/init.d/ssh";
$configscript="config_ssh.php";
$configname="ssh";

$configfile="/etc/ssh/sshd_config";

$autorestart=1;

$simpleconfig=array(
	"Port" => array( "Default is 22.", "text" , "Port" , "22" ),
	"Permit Root-Login" => array( "Permit login as root." , "checkbox" , "PermitRootLogin" , "yes" , "no" , "yes" ),
	"Permit Empty Passwords" => array( "Permit login with empty passwords." , "checkbox" , "PermitEmptyPasswords" , "yes" , "no" , "no" ),
	"X11-Forwarding" => array( "Enables X11-Forwarding." , "checkbox" , "X11Forwarding" , "yes" , "no" , "no" ),
	"Allow Pubkey-Login" => array ( "Enables Login via Pubkey-File." , "checkbox" , "PubkeyAuthentication" , "yes" , "no" , "yes" ),
	"Enable Passwords" => array( "Enables Login via Password." , "checkbox" , "PasswordAuthentication" , "yes" , "no" , "yes" ),
	"Banner" => array( "Greeting banner displayed by FTP when a connection first comes in." , "textarea" , "Banner" , "Hello! :)" ),
);

include "lib/simpleconfig.php";

?>
