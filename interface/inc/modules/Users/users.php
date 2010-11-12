<?php

if(isset($_GET['d']) && is_numeric($_GET['d']) && $_GET['d']>=$minuid && $_GET['d']<=$maxuid){
	$user=posix_getpwuid($_GET['d']);
	if(is_array($user)){
		exec("sudo userdel ".$user['name']);
	}
}

if(isset($_GET['e']) && is_numeric($_GET['e']) && $_GET['e']>=$minuid && $_GET['e']<=$maxuid && ($user=posix_getpwuid($_GET['e'])) && is_array($user)){
	if(isset($_POST['fullname'])){
		$usermod="sudo usermod ";
		$_POST['groups'][]=$_POST['group'];
		if(isset($_POST['groups']) && is_array($_POST['groups'])){
			$groups="";
			foreach($_POST['groups'] as $group){
				if(is_numeric($group) && is_array(posix_getgrgid($group))){
					$groups.=$group.",";
				}
			}
			$groups=substr($groups,0,-1);
			if(!empty($groups)) $usermod.="-G ".$groups.' ';
		}
		$usermod.="-d '".$_POST['homedir']."' ";
		$usermod.="-c '".$_POST['fullname']."' ";
		$usermod.="-g '".$_POST['group']."' ";
		$usermod.="-s '".$_POST['shell']."' ";
		if(!empty($_POST['pass'])){
			$salt="";
			$chars=array_merge(range("A","Z"),range("a","z"),range("0","9"));
			for($i=1;$i<=15;$i++){
				$char=array_rand($chars);
				$char=$chars[$char];
				$salt.=$char;
			}
			$pw=crypt($_POST['pass'],$salt);
			$usermod.="-p '".$pw."' ";
		}
		$usermod.=$user['name'];

		exec($usermod);

		echo '<span style="color:green">Saved!</span>';
		$user=posix_getpwuid($_GET['e']);
	}
	echo '<form action="" method="post">';
	echo '<h3>Edit User</h3>';
	echo '<fieldset>';
	echo '<p><label>Username:</label><input type="text" class="text-long" disabled="disabled" value="'.$user['name'].'" /></p>';
	echo '<p><label>Full Name:</label><input type="text" class="text-long" name="fullname" value="'.$user['gecos'].'" /></p>';
	echo '<p><label>Home:</label><input type="text" class="text-long" name="homedir" value="'.$user['dir'].'" /></p>';
	echo '<p><label>Shell:</label><select name="shell">';
	echo '<option>/bin/false</option>';
	$shells=explode("\n",file_get_contents("/etc/shells"));
	foreach($shells as $shell){
		$shell=trim($shell);
		if(substr($shell,0,1)!="#"){
			echo '<option';
			if($shell==$user['shell']) echo ' selected="selected"';
			echo '>'.$shell.'</option>';
		}
	}
	echo '</select></p>';
	echo '<p><label>Main Group:</label><select name="group">';
	$groups=array();
	exec("cat /etc/group | awk -F ':' '{print $3}'",$groups);
	foreach($groups as $group){
		if($group>=$mingid && $group<=$maxgid){
			$group=posix_getgrgid($group);
			print_r($group);
			echo '<option value="'.$group['gid'].'"';
			if($user['gid']==$group['gid']) echo ' selected="selected"';
			echo '>'.$group['name'].'</option>';
		}
	}
	echo '</select></p>';
	echo '<p><label>Groups:</label><select name="groups[]" multiple="multiple" size="5">';
	foreach($groups as $group){
		if($group>=$mingid && $group<=$maxgid){
			$group=posix_getgrgid($group);
			echo '<option value="'.$group['gid'].'"';
			if(in_array($user['name'],$group['members'])) echo ' selected="selected"';
			echo '>'.$group['name'].'</option>';
		}
	}
	echo '</select></p>';
	echo '<p><label>New Password:</label><input type="password" class="text-long" name="pass" value="" /></p>';
	echo '<input type="submit" value="Save" />';
	echo '</fieldset>';
	echo '</form>';
}else{
	$users=array();
	exec("cat /etc/passwd | awk -F ':' '{print $3}' | sort -n",$users);
	echo '<h3>Users</h3>';
	echo '<table cellpadding="0" cellspacing="0">';
	echo '<tr><th>Name</th><th>Home</th><th>Shell</th><th class="action">Actions</th></tr>';
	foreach($users as $user){
		if($user>=$minuid && $user<=$maxuid){
			$user=posix_getpwuid($user);
			if(is_array($user)){
				echo '<tr>';
				echo '<td>'.$user['name'];
				if(!empty($user['gecos']) && $user['name']!=$user['gecos']){
					echo ' ( '.$user['gecos'].' )';
				}
				echo '</td>';
				echo '<td>'.$user['dir'].'</td>';
				echo '<td>'.$user['shell'].'</td>';
				echo '<td class="action"><a href="?p='.$_GET['p'].'&e='.$user['uid'].'" class="edit">Edit</a><a href="?p='.$_GET['p'].'&d='.$user['uid'].'" class="delete">Delete</a></td>';
				echo '</tr>';
			}
		}
	}
	echo '</table>';
}

?>
