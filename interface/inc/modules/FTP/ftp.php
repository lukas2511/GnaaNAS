<?php

$title="FTP";
$startstopscript="/etc/init.d/pure-ftpd";
$configscript="config_ftp.php";
$configname="ftp";

$autorestart=1;
$simpleconfig=array(
	"TCP port" => array( "Default is 21.", "text" , "Bind" , "21" ),
	"Number of clients" => array( "Maximum number of simultaneous clients." , "text" , "MaxClientsNumber" , "5" ),
	"Max. conn. per IP" => array( "Maximum number of connections per IP address ( 0 = unlimited )." , "text" , "MaxClientsPerIP", "2" ),
	"Timeout" => array( "Maximum idle time in seconds." , "text" , "MaxIdleTime", "600" ),
	"Permit root login" => array( "Specifies whether it is allowed to login as superuser (root) directly." , "checkbox" , "MinUID" , "0" , $minuid, $minuid ),
	"Anonymous users only" => array ( "Only allow anonymous users. Use this on a public FTP site with no remote FTP access to real accounts." , "checkbox" , "AnonymousOnly" , "yes" , "no" , "no" ),
	"Local users only" => array( "Only allow authenticated users. Anonymous logins are prohibited." , "checkbox" , "NoAnonymous" , "yes" , "no" , "yes" ),
	"Display hidden files" => array( "Show hidden files" , "checkbox" , "DisplayDotFiles" , "yes" , "no" , "yes" ),
	//"Banner" => array( "Greeting banner displayed by FTP when a connection first comes in." , "textarea" , "" , "Hello! :)" ),
);

$advconfig=array(
	"Create mask" => array( "Use this option to override the file creation mask (000 by default)." , "text" , "Umask" , "000 000" ),
	"FXP" => array( "FXP allows transfers between two servers without any file data going to the client asking for the transfer." , "checkbox" , "AllowUserFXP" , "yes" , "no" , "no" ),
	"Default root" => array( "chroot() everyone, but root." , "checkbox" , "ChrootEveryone" , "yes" , "no" , "yes" , "If default root is enabled, a chroot operation is performed immediately after a client authenticates. This can be used to effectively isolate the client from a portion of the host system filespace." ),
	"Local user bandwidth" => array ( "Local user bandwith in KB/s. An empty field means infinity." , "text" , "UserBandwidth" , "" ),
	"Anonymous user bandwidth" => array ( "Anonymous user bandwith in KB/s. An empty field means infinity." , "text" , "AnonymousBandwidth" , "" ),
	//"SSL/TLS" => array ( "Enable TLS/SSL connections." , "checkbox" , "TLS" , "yes" , "no" , "no" ),
);

include "lib/simpleconfig.php";

?>
