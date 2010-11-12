<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GnaaNAS</title>

<!-- CSS -->
<link href="style/css/transdmin.css" rel="stylesheet" type="text/css" media="screen" />
</head>

<body>
	<div id="wrapper">
    	<!-- h1 tag stays for the logo, you can use the a tag for linking the index page -->
    	<h1><a href="index.php"><span>GnaaNAS</span></a></h1>
        
        <!-- You can name the links with lowercase, they will be transformed to uppercase by CSS, we prefered to name them with uppercase to have the same effect with disabled stylesheet -->
        <ul id="mainNav">
        	<?php include "inc/menu.php"; ?>
        </ul>
        <!-- // #end mainNav -->
        
        <div id="containerHolder">
			<div id="container">
        		<div id="sidebar">
                	<ul class="sideNav">
			<?php include "inc/sidebar.php"; ?>
                    </ul>
                    <!-- // .sideNav -->
                </div>    
                <!-- // #sidebar -->
                
		<?php include "inc/real_content.php"; ?>                
                <!-- // #main -->
                
                <div class="clear"></div>
            </div>
            <!-- // #container -->
        </div>	
        <!-- // #containerHolder -->
        
        <p id="footer"><?php

if(isset($modpages[$curpage][$subpage])){
	$module=$modpages[$curpage][$subpage];
	$module=$modules[$module];
	if(isset($module['authorlink'])){
		$author='<a href="'.$module['authorlink'].'">'.$module['author'].'</a>';
	}else{
		$author=$module['author'];
	}
	?>Module: <?php echo $module['name'] ?> ( Version <?php echo $module['version'] ?> by <?php echo $author; ?> )<?php
}else{
	?>Gnaa<?php for($i=1;$i<=mt_rand(0,148);$i++){ echo "a"; }
}
?>.</p>

  </div>
    <!-- // #wrapper -->
</body>
</html>
