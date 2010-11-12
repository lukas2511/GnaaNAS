<?php

$title="NFS";
$configscript="config_nfs.php";
$configname="nfs";
$startstopscript="/etc/init.d/nfs-kernel-server";
$autorestart=1;
$basepath="/var/nas/inc/modules/".$module."/.simpleconfig/".$configname."/";

if(isset($_GET['m']) && isset($_GET['a'])){
	if(!empty($_POST['path']) && !empty($_POST['network']) && is_numeric($_POST['netsize'])){
		$path=$_POST['path'];
		$network=$_POST['network']."/".$_POST['netsize'];
		$options=$_POST['options'];
		$id=rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);
		while(root_file_exists($basepath.$id)) $id=rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);
		$array=array("path"=>$path,"network"=>$network,"options"=>$options,"id"=>$id);
		root_file_put_contents($basepath.$id.".share",serialize($array));
		exec("sudo php /var/nas/inc/modules/".$module."/".$configscript." ".base64_encode($module)." ".base64_encode($configname));
		echo '<span style="color:green">Share was added!</span>';
	}
	echo '<form action="" method="post">';
	echo '<h3>Add NFS Share</h3>';
	echo '<fieldset>';
	echo '<p><label>Path:</label><input name="path" type="text" class="text-long" value="/mnt" /></p>';
	echo '<p><label>Network:</label><input name="network" type="text" class="text-long" value="'.$_SERVER['REMOTE_ADDR'].'" /> / <select name="netsize">';
	for($i=32;$i>=1;$i--){
		echo '<option';
		if($i==32) echo ' selected="selected"';
		echo '>'.$i.'</option>';
	}
	echo '</select></p>';
	echo '<p><label>Options:</label><input name="options" type="text" class="text-long" value="rw,sync,no_root_squash,no_subtree_check" /></p>';
	echo '<p><input type="submit" value="Add Share" /></p>';
	echo '</fieldset>';
	echo '</form>';
	echo '<br /><br /><a href="?p='.$_GET['p'].'&m">Back</a>';
}elseif(isset($_GET['m'])){
	if(isset($_GET['d']) && is_numeric($_GET['d'])){
		exec("sudo rm ".$basepath.$_GET['d'].".share");
		exec("sudo php /var/nas/inc/modules/".$module."/".$configscript." ".base64_encode($module)." ".base64_encode($configname));
	}

	echo '<h3>NFS Shares</h3><table cellpadding="0" cellspacing="0"><tr><th>Path</th><th>Network / IP</th><th class="action">Actions</th></tr>';
	$shares=glob($basepath."*");
	foreach($shares as $shareid){
		if(stristr($shareid,".share")){
			$share=unserialize(root_file_get_contents($shareid));
			echo '<tr><td>'.$share['path'].'</td><td>'.$share['network'].'</td><td class="action"><a href="?p='.$_GET['p'].'&m&d='.$share['id'].'" class="delete">Delete</a></td></tr>';
		}
	}
	echo '</table>';
	echo '<br /><br /><a href="?p='.$_GET['p'].'&m&a">Add Share</a>';
}else{
	$simpleconfig=array();
	include "lib/simpleconfig.php";
	echo '<a href="?p='.$_GET['p'].'&m">Manage Shares</a>';
}
