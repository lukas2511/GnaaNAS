<?php

foreach($pages as $name => $subs){
	echo '<li>';
	echo '<a href="?p='.$name.'"';
	if($curpage==$name || isset($subs[$curpage])){
		echo ' class="active"';
	}
	echo '>';
	echo strtoupper($name);
	echo '</a>';
	echo '</li>';
}

?>
<li class="logout"><a href="?p=logout&l=<?php echo rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9); ?>">LOGOUT</a></li>
