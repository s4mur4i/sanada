#!/usr/bin/php
<?
	$limits = array(1,3,7);
	foreach($limits as &$limit){
		$limit *= 24*60*60;
	}
	unset($limit); // FUCK YOU: https://bugs.php.net/bug.php?id=29992
	echo("DEBUG: unset(limit)\n");
	foreach($limits as $limit){
		echo("DEBUG: limit: ".$limit."\n");
	}
	unset($limit); // FUCK YOU: https://bugs.php.net/bug.php?id=29992
	echo("DEBUG: unset(limit)\n");
	foreach($limits as $limit){
		echo("DEBUG: limit: ".$limit."\n");
	}
?>
