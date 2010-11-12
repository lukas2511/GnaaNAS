<?php

$title="MPD";
$startstopscript="/etc/init.d/mpd:/etc/init.d/icecast2";
$configscript="config_mpd.php";
$configname="mpd";

$autorestart=1;

$ipass=rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);

if(file_get_contents("/var/nas/inc/modules/".$modpages[$curpage][$subpage]."/.simpleconfig/".$configname."/".$configname.".service")!="/bin/true"){
	echo '<a href="?p='.$_GET['p'].'&act=prev">&laquo;</a>  <a href="?p='.$_GET['p'].'&act=toggle">&#8211;</a>  <a href="?p='.$_GET['p'].'&act=next">&raquo;</a><br />';

	if(isset($_GET['act']) && !empty($_GET['act'])){
		$sock=fsockopen("localhost",file_get_contents("/var/nas/inc/modules/".$modpages[$curpage][$subpage]."/.simpleconfig/".$configname."/Port"));
		$password=file_get_contents("/var/nas/inc/modules/".$modpages[$curpage][$subpage]."/.simpleconfig/".$configname."/Pass");
		switch($_GET['act']){
			case 'prev': $cmd="previous"; break;
			case 'next': $cmd="next"; break;
			case 'toggle': $cmd="pause"; break;
		}
		if(!empty($password)){
			fwrite($sock,"password ".$password."\r\n");
		}
		fwrite($sock,$cmd."\r\n");
		fclose($sock);
	}
}

$simpleconfig=array(
	"Music Directory" => array ( "Where are the files?" , "text" , "Dir" , "/mnt" ),
	"Password" => array ( "Password for MPD-Control" , "text" , "Pass" , "" ),
	"MPD Port" => array( "Default is 6600.", "text" , "Port" , "6600" ),
	"Remote Control" => array ( "Allow Remote-Control via Ethernet" , "checkbox" , "Remote" , "yes" , "no" , "yes" ),
	"IceCast Stream" => array ( "Enable Remote Playback" , "checkbox" , "Stream" , "yes" , "no" , "yes" ),
	"IceCast Port" => array( "Default is 8080." , "text" , "IPort" , "8080" ),
	"IceCast Password" => array ( "Password to authenticate against IceCast 2 Server" , "text" ,  "IPass" , $ipass ),
);

$advconfig=array(
	"IceCast Auth" => array ( "Passwords can be managed in the IceCast2-WebInterface" , "checkbox" , "UseAuth" , "yes" , "no" , "yes" ),
	"IceCast Mount" => array ( "Mountpoint used by MPD" , "text" , "Mount" , "/mpd.mp3" ),
	"IceCast Fallback" => array ("Silence if MPD is not playing" , "checkbox" , "AllowFallback" , "yes" , "no" , "yes" ),
	"User" => array ( "Which user should the server be run under?" , "text" , "User" , "mpd" ),
	"Local Playback" => array ( "Enable Local Playback" , "checkbox" , "Local" , "yes" , "no" , "no" ),
	"Local Audio Device" => array( "Default is hw:0,0", "text" , "Device" , "hw:0,0" ),
	"Enable Hardware Mixer" => array( "Enable Hardware Mixer for Local Playback" , "checkbox" , "HardwareMixer" , "yes" , "no" , "no" ),
	"Mixer Device" => array( "Default is /dev/mixer", "text" , "Mixer" , "/dev/mixer" ),
);

include "lib/simpleconfig.php";

?>
