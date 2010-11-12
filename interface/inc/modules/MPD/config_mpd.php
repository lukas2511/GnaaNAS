<?php

$basepath="/var/nas/inc/modules/".base64_decode($_SERVER['argv'][1])."/.simpleconfig/".base64_decode($_SERVER['argv'][2]);

if(file_get_contents($basepath."/User")=="") die();

$lines="";

$lines.="playlist_directory \"/var/lib/mpd/playlists\"\n";
$lines.="db_file \"/var/lib/mpd/tag_cache\"\n";
$lines.="log_file \"/var/log/mpd/mpd.log\"\n";
$lines.="pid_file \"/var/run/mpd/pid\"\n";
$lines.="state_file \"/var/lib/mpd/state\"\n";
$lines.="filesystem_charset \"UTF-8\"\n";
$lines.="id3v1_encoding \"UTF-8\"\n";
$lines.="error_file \"/var/log/mpd/errors.log\"\n";

$pass=file_get_contents($basepath."/Pass");
$ipass=file_get_contents($basepath."/IPass");
if(!empty($pass)){
	$lines.='password "'.$pass.'@read,add,control,admin"'."\n";
	$lines.='default_permissions ""'."\n";
}else{
	$lines.='default_permissions "read,add,control,admin"'."\n";
}
$lines.='music_directory "'.file_get_contents($basepath."/Dir").'"'."\n";
$lines.='user "'.file_get_contents($basepath."/User").'"'."\n";
$lines.='port "'.file_get_contents($basepath."/Port").'"'."\n";
if(file_get_contents($basepath."/Remote")=="no"){
	$lines.='bind_to_address "localhost"'."\n";
}
if(file_get_contents($basepath."/Stream")=="yes"){
	$lines.="audio_output {\ntype \"shout\"\nname \"MPD Stream\"\nhost \"localhost\"\nport \"".file_get_contents($basepath."/IPort")."\"\nmount \"".file_get_contents($basepath."/Mount")."\"\npassword \"".$ipass."\"\nbitrate \"160\"\nformat \"44100:16:2\"\nprotocol \"icecast2\"\nencoding \"mp3\"\n}\n";
}
if(file_get_contents($basepath."/Local")=="yes"){
	$lines.="audio_output {\ntype \"alsa\"\nname \"Local Playback\"\ndevice \"".file_get_contents($basepath."/Device")."\"\nformat \"44100:16:2\"\n";
	$mixer=file_get_contents($basepath."/Mixer");
	if(file_get_contents($basepath."/HardwareMixer")=="yes" && !empty($mixer)){
		$lines.="mixer_device \"".file_get_contents($basepath."/Mixer")."\"\n";
	}
	$lines.="}\n";
	if(file_get_contents($basepath."/HardwareMixer")=="yes" && !empty($mixer)){
		$lines.="mixer_type \"hardware\"\n";
	}else{
		$lines.="mixer_type \"software\"\n";
	}
}

file_put_contents("/etc/mpd.conf",$lines);

if(file_get_contents($basepath."/Stream")=="yes"){
	$icecastc='<icecast><limits><clients>100</clients><sources>2</sources><threadpool>5</threadpool><queue-size>524288</queue-size><client-timeout>30</client-timeout><header-timeout>15</header-timeout><source-timeout>10</source-timeout><burst-on-connect>1</burst-on-connect><burst-size>65535</burst-size></limits><authentication><source-password>'.$ipass.'</source-password><relay-password>'.$ipass.'</relay-password><admin-user>admin</admin-user><admin-password>'.$ipass.'</admin-password></authentication><hostname>'.strtr(file_get_contents("/etc/hostname"),array("\n"=>"","\r"=>"")).'</hostname><listen-socket><port>'.file_get_contents($basepath."/IPort").'</port></listen-socket><mount><mount-name>'.file_get_contents($basepath."/Mount").'</mount-name>';
	if(file_get_contents($basepath."/UseAuth")=="yes"){
		$icecastc.='<authentication type="htpasswd"><option name="filename" value="mpdauth"/><option name="allow_duplicate_users" value="1"/></authentication>';
	}
	if(file_get_contents($basepath."/AllowFallback")=="yes"){
		$icecastc.='<fallback-mount>/stille.mp3</fallback-mount><fallback-override>1</fallback-override>';
	}
	$icecastc.='</mount><fileserve>1</fileserve><paths><basedir>/usr/share/icecast2</basedir><logdir>/var/log/icecast2</logdir><webroot>/usr/share/icecast2/web</webroot><adminroot>/usr/share/icecast2/admin</adminroot><alias source="/" dest="/status.xsl"/></paths><logging><accesslog>access.log</accesslog><errorlog>error.log</errorlog><loglevel>3</loglevel><logsize>10000</logsize></logging><security><chroot>0</chroot></security></icecast>';
	file_put_contents("/etc/icecast2/icecast.xml",$icecastc);
	file_put_contents("/etc/default/icecast2","CONFIGFILE=\"/etc/icecast2/icecast.xml\"\nUSERID=icecast2\nGROUPID=icecast\nENABLE=true");
}else{
	file_put_contents("/etc/default/icecast2","CONFIGFILE=\"/etc/icecast2/icecast.xml\"\nUSERID=icecast2\nGROUPID=icecast\nENABLE=true");
	exec("/etc/init.d/icecast2 stop");
	file_put_contents("/etc/default/icecast2","CONFIGFILE=\"/etc/icecast2/icecast.xml\"\nUSERID=icecast2\nGROUPID=icecast\nENABLE=false");
}

exec("chown -R ".file_get_contents($basepath."/User")." /var/*/mpd /etc/mpd.conf");

exec("adduser ".file_get_contents($basepath."/User")." audio");

?>
