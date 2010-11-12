<?php

if(isset($pages[$curpage])){
	foreach($pages[$curpage] as $name => $blah){
		echo '<li>';
		echo '<a href="?p='.$curpage.'/'.$name.'"';
		if($name==$subpage) echo ' class="active"';
		echo '>'.$name.'</a></li>';
	}
}

?>
