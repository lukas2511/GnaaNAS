<?php

echo '<h3>Modules</h3>';
echo '<table cellpadding="0" cellspacing="0">';

foreach($modules_source as $module){
	$name=$module['name'];
	echo '<tr><td>'.$module['name'].' ( Version: '.$module['version'].' )</td><td>'.$module['desc'].'</td><td>';
	if(!empty($module['authorlink'])){
		echo '<a href="'.$module['authorlink'].'">'.$module['author'].'</a>';
	}else{
		echo $module['author'];
	}
	echo '</td><td class="action">';
	if(isset($modules[$name])){
		echo '<a href="?p='.$_GET['p'].'&r='.$name.'" class="delete">Remove</a>';
		if($module['version']!=$modules[$name]['version']){
			echo '<a href="?p='.$_GET['p'].'&i='.$name.'" class="edit">Update</a>';
		}
	}else{
		echo '<a href="?p='.$_GET['p'].'&i='.$name.'" class="view">Install</a>';
	}
	echo '</td>';
	echo '</tr>';
}

echo "</table>";

?>
