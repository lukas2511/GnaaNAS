<!-- h2 stays for breadcrumbs -->
<h2><a href="?p=<?php echo $curpage; ?>"><?php echo $curpage; ?></a> &raquo; <a href="" class="active"><?php echo $subpage; ?></a></h2>
<div id="main">
<?php
if(isset($modpages[$curpage][$subpage])) $module=$modpages[$curpage][$subpage];

if(isset($content[$curpage][$subpage])){
	echo $content[$curpage][$subpage];
}elseif(isset($curpage)){
	if(isset($pages[$curpage])){
		foreach($pages[$curpage] as $name => $blah){
			if($name==$subpage){
				if(file_exists($pages[$curpage][$subpage])){
					if(isset($modpages[$curpage][$subpage]) && file_exists("/var/nas/inc/modules/".$modpages[$curpage][$subpage]."/install.sh") && !file_exists("/var/nas/inc/installed/".$modpages[$curpage][$subpage].".installed")){
						include "inc/installer.php";
					}else{
						include $pages[$curpage][$subpage];
					}
				}else{
					include "inc/404.php";
				}
			}
		}
	}else{
		include "inc/404.php";
	}
}else{
	include "inc/404.php";
}
?>
</div>
