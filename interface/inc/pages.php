<?php

$pages=array();
$content=array();

$pages['Home']=array("Dashboard" => "inc/dashboard.php", "Update" => "inc/update.php", "Modules"=> "inc/modules.php");

$modules=array();
$modpages=array();
foreach(glob("inc/modules/*") as $module){
	if(file_exists($module."/module.php")){
		$module=basename($module);
		if(isset($author)) unset($author);
		if(isset($authorlink)) unset($authorlink);
		if(isset($modulepages)) unset($modulepages);
		if(isset($name)) unset($name);
		if(isset($desc)) unset($desc);
		if(isset($version)) unset($version);
		if(isset($requiresroot)) unset($requiresroot);
		if(isset($updateurl)) unset($updateurl);
		include "inc/modules/".$module."/module.php";
		if(isset($author) && isset($version) && isset($name) && isset($desc)){
			$modules[$module]=array();
			$modules[$module]['name']=$name;
			$modules[$module]['author']=$author;
			$modules[$module]['version']=$version;
			if(isset($updateurl)){
				$modules[$module]['updateurl']=$updateurl;
			}
			if(isset($authorlink)){
				$modules[$module]['authorlink']=$authorlink;
			}
			$modules[$module]['desc']=$desc;
			if(isset($modulepages) && ((isset($requiresroot) && $requiresroot && $_USER->uid==0) || !isset($requiresroot) || !$requiresroot)){
				foreach($modulepages as $page => $subpages){
					if(!isset($content[$page]) && !isset($pages[$page][$page]) && !isset($modulepages[$page][$page])) $content[$page][$page]="Please choose a subpage from the sidebar";
					foreach($subpages as $subpage => $file){
						$pages[$page][$subpage]="inc/modules/".$module."/".$file;
						$modpages[$page][$subpage]=$module;
					}
				}
			}
		}
	}
}
