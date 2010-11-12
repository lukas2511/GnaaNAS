<?php

$shells=explode("\n",file_get_contents("/etc/shells"));
$groups=array(); exec("cat /etc/group | awk -F ':' '{print $3}'",$groups);
$error="";

if(isset($_POST['fullname'])){
	if(empty($_POST['username']) || !preg_match("/^([a-z0-9]+)$/",$_POST['username']) || strlen($_POST['username'])<4 || is_array(posix_getpwnam($_POST['username']))){
		$error.="Invalid Username (Must not exist, Must be at least 4 chars long, Must constist of small letters and numbers)<br />";
	}
	if(!empty($_POST['pass']) && strlen($_POST['pass'])<=4){
		$error.="Invalid Password (Must be at least 4 chars long or empty for internal usage)<br />";
	}
	if(empty($_POST['shell']) || (!in_array($_POST['shell'],$shells) && $_POST['shell']!="/bin/false")){
		$error.="Invalid Shell<br />";
	}
	if(empty($_POST['group']) || !in_array($_POST['group'],$groups)){
		$error.="Invalid Main Group<br />";
	}
	if(empty($_POST['homedir']) || !preg_match("/^([a-zA-Z\ \._\-\/]+)$/",$_POST['homedir']) || !root_file_exists($_POST['homedir']) || !root_is_dir($_POST['homedir'])){
		$error.="Invalid Home-Dir (Must exist)<br />";
	}
	if(empty($error)){
		$useradd="sudo useradd ";
		$_POST['groups'][]=$_POST['group'];
		if(isset($_POST['groups']) && is_array($_POST['groups'])){
			$groups="";
			foreach($_POST['groups'] as $group){
				if(is_numeric($group) && is_array(posix_getgrgid($group))){
					$groups.=$group.",";
				}
			}
			$groups=substr($groups,0,-1);
			if(!empty($groups)) $useradd.="-G ".$groups.' ';
		}
		$useradd.="-d '".$_POST['homedir']."' ";
		$useradd.="-c '".$_POST['fullname']."' ";
		$useradd.="-g '".$_POST['group']."' ";
		$useradd.="-s '".$_POST['shell']."' ";
		if(!empty($_POST['pass'])){
			$salt="";
			$chars=array_merge(range("A","Z"),range("a","z"),range("0","9"));
			for($i=1;$i<=15;$i++){
				$char=array_rand($chars);
				$char=$chars[$char];
				$salt.=$char;
			}
			$pw=crypt($_POST['pass'],$salt);
			$useradd.="-p '".$pw."' ";
		}
		$useradd.=$_POST['username'];

		exec($useradd);

		echo '<span style="color:green">User was added!</span>';
	}
}
echo '<form action="" method="post">';
echo '<h3>Add User</h3>';
echo '<fieldset>';
if(!empty($error)){
	echo '<p style="color:red">'.$error.'</p>';
}
echo '<p><label>Username:</label><input name="username" type="text" class="text-long" value="" /></p>';
echo '<p><label>Full Name:</label><input type="text" class="text-long" name="fullname" value="" /></p>';
echo '<p><label>Home:</label><input type="text" class="text-long" name="homedir" value="/mnt/" /></p>';
echo '<p><label>Shell:</label><select name="shell">';
echo '<option>/bin/false</option>';
foreach($shells as $shell){
	$shell=trim($shell);
	if(substr($shell,0,1)!="#"){
		echo '<option';
		if($shell=="/bin/bash") echo ' selected="selected"';
		echo '>'.$shell.'</option>';
	}
}
echo '</select></p>';
echo '<p><label>Main Group:</label><select name="group">';
foreach($groups as $group){
	if($group>=$mingid && $group<=$maxgid){
		$group=posix_getgrgid($group);
		print_r($group);
		echo '<option value="'.$group['gid'].'"';
		echo '>'.$group['name'].'</option>';
	}
}
echo '</select></p>';
echo '<p><label>Groups:</label><select name="groups[]" multiple="multiple" size="5">';
foreach($groups as $group){
	if($group>=$mingid && $group<=$maxgid){
		$group=posix_getgrgid($group);
		echo '<option value="'.$group['gid'].'"';
		echo '>'.$group['name'].'</option>';
	}
}
echo '</select></p>';
echo '<p><label>Password:</label><input type="password" class="text-long" name="pass" value="" /></p>';
echo '<input type="submit" value="Save" />';
echo '</fieldset>';
echo '</form>';
