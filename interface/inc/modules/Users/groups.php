<?php

if(isset($_GET['d']) && is_numeric($_GET['d']) && $_GET['d']>=$mingid && $_GET['d']<=$maxgid){
	$group=posix_getgrgid($_GET['d']);
	if(count($group['members'])){
		$members="";
		foreach($group['members'] as $member){
			$members.=$member.", ";
		}
		$members=substr($members,0,-2);
		echo "<span style='color:red'>Group has members: ".$members."</span>";
	}else{
		exec("sudo groupdel ".$group['name']);
	}
}

$groups=array(); exec("cat /etc/group | awk -F ':' '{print $3}' | sort -n",$groups);

echo '<h3>Groups</h3>';
echo '<table cellpadding="0" cellspacing="0">';
echo '<tr><th>Group</th><th class="action">Actions</th></tr>';

foreach($groups as $group){
	if($group>=$mingid && $group<=$maxgid){
		$group=posix_getgrgid($group);
		echo '<tr>';
		echo '<td>'.$group['name'].'</td>';
		echo '<td class="action"><a href="?p='.$_GET['p'].'&d='.$group['gid'].'" class="delete">Delete</a></td>';
		echo '</tr>';
	}
}

echo '</table>';

?>
