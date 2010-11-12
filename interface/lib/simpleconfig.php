<?php

if(isset($module)) unset($module);

if(isset($modpages[$curpage][$subpage]) && isset($configname)){
	$module=$modpages[$curpage][$subpage];
	$basepath="/var/nas/inc/modules/".$module."/.simpleconfig/".$configname."/";
	$servicefile=$basepath.$configname.".service";
exec("sudo mkdir -p ".$basepath);


if(isset($startstopscript)){
	$something["Enable"]=array ( "Enable $title" , "checkbox" , $servicefile , $startstopscript , "/bin/true" , "/bin/true" );
	$simpleconfig=array_merge($something,$simpleconfig);
}

$files=array();

foreach($simpleconfig as $name => $option){
	if(!stristr($option[2],"/") && isset($basepath)) $option[2]=$basepath.$option[2];
	$files[]=$option[2];
}

if(isset($advconfig)){
	foreach($advconfig as $name => $option){
		if(!stristr($option[2],"/") && isset($basepath)) $option[2]=$basepath.$option[2];
		$files[]=$option[2];
	}
}

$files=root_batch_get($files);

if(isset($_POST['action']) && $_POST['action']=='save'){
	foreach($simpleconfig as $name => $option){
		$bname=base64_encode($name);
		if(!stristr($option[2],"/") && isset($basepath)) $option[2]=$basepath.$option[2];
		$file=$option[2];
		if(($option[1]=="text" | $option[1]=="textarea") && $files[$file]!=$_POST[$bname]){
			root_file_put_contents($file,$_POST[$bname]);
			$files[$file]=$_POST[$bname];
		}elseif($option[1]=="checkbox"){
			if(isset($_POST[$bname]) && $files[$file]!=$option[3]){
				root_file_put_contents($file,$option[3]);
				$files[$file]=$option[3];
				if($name=="Enable"){
					$rcscripts=explode(":",$startstopscript);
					foreach($rcscripts as $rcscript){
						$rcscriptb=basename($rcscript);
						exec("sudo update-rc.d ".$rcscriptb." defaults");
						exec("sudo ".$rcscript." start");
					}
				}
			}elseif(!isset($_POST[$bname]) && $files[$file]!=$option[4]){
				root_file_put_contents($file,$option[4]);
				$files[$file]=$option[4];
				if($name=="Enable"){
					$rcscripts=explode(":",$startstopscript);
					foreach($rcscripts as $rcscript){
						$rcscriptb=basename($rcscript);
						exec("sudo update-rc.d -f ".$rcscriptb." remove");
						exec("sudo ".$rcscript." stop");
					}
				}
			}
		}
	}
	if(isset($advconfig)){
		foreach($advconfig as $name => $option){
			$bname=base64_encode($name);
			if(!stristr($option[2],"/") && isset($basepath)) $option[2]=$basepath.$option[2];
			$file=$option[2];
			if(($option[1]=="text" | $option[1]=="textarea") && $files[$file]!=$_POST[$bname]){
				root_file_put_contents($file,$_POST[$bname]);
				$files[$file]=$_POST[$bname];
			}elseif($option[1]=="checkbox"){
				if(isset($_POST[$bname]) && $files[$file]!=$option[3]){
					root_file_put_contents($file,$option[3]);
					$files[$file]=$option[3];
				}elseif(!isset($_POST[$bname]) && $files[$file]!=$option[4]){
					root_file_put_contents($file,$option[4]);
					$files[$file]=$option[4];
				}
			}
		}
	}
	if(isset($configscript) && root_file_exists("/var/nas/inc/modules/".$module."/".$configscript)){
		exec("sudo php /var/nas/inc/modules/".$module."/".$configscript." ".base64_encode($module)." ".base64_encode($configname));
	}
	if(isset($startstopscript) && $autorestart && $files[$servicefile]!="/bin/true"){
		$rcscripts=explode(":",$startstopscript);
		foreach($rcscripts as $rcscript){
			exec("sudo ".$rcscript." restart");
		}
	}
}

echo '<form action="" method="post"><input type="hidden" name="action" value="save" />';
echo '<h3>'.$title.'</h3>';
echo '<fieldset>';
if(isset($advconfig)){
	echo '<h3 style="margin:0;margin-bottom:10px;padding:0;">Simple Config</h3>';
}
foreach($simpleconfig as $name => $option){
	echo '<p><label>'.$name.'</label>';
	if(!stristr($option[2],"/") && isset($basepath)) $option[2]=$basepath.$option[2];
	$file=$option[2];
	if(isset($files[$file])){
		$content=$files[$file];
		if(empty($content)) $content=$option[3];
	}else{
		if($option[1]=="checkbox"){
			$content=$option[5];
		}else{
			$content=$option[3];
		}
	}

	if($option[1]=="text"){
		echo '<input type="text" class="text-long" name="'.base64_encode($name).'" value="'.$content.'" title="'.$option[0].'" />';
	}elseif($option[1]=="checkbox"){
		echo ' <input title="'.$option[0].'" type="checkbox" class="text-long" name="'.base64_encode($name).'" ';
		if($content==$option[3]) echo 'checked="checked" ';
		echo '/>';
	}elseif($option[1]=="textarea"){
		echo '<textarea name="'.base64_encode($name).'" title="'.$option[0].'" >'.$content.'</textarea>';
	}


	echo '</p>';
}

if(isset($advconfig)){
	echo '<p><input type="submit" value="Save" /></p>';
	echo '<h3 style="margin:0;margin-bottom:10px;padding:0;">Advanced Config</h3>';
	foreach($advconfig as $name => $option){
		echo '<p><label>'.$name.'</label>';
		if(!stristr($option[2],"/") && isset($basepath)) $option[2]=$basepath.$option[2];
		$file=$option[2];
		if(isset($files[$file])){
			$content=$files[$file];
			if(empty($content)) $content=$option[3];
		}else{
			if($option[1]=="checkbox"){
				$content=$option[5];
			}else{
				$content=$option[3];
			}
		}

		if($option[1]=="text"){
			echo '<input type="text" class="text-long" name="'.base64_encode($name).'" value="'.$content.'" title="'.$option[0].'" />';
		}elseif($option[1]=="checkbox"){
			echo ' <input title="'.$option[0].'" type="checkbox" class="text-long" name="'.base64_encode($name).'" ';
			if($content==$option[3]) echo 'checked="checked" ';
			echo '/>';
		}


		echo '</p>';
	}
}
echo '<p><input type="submit" value="Save" /></p>';
echo '</fieldset>';
echo '</form>';

}

?>
