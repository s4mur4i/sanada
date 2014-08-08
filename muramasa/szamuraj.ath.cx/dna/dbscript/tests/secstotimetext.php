#!/usr/bin/php
<?
	if(!defined("__FUNC__"))
		define("__FUNC__","file:".__FILE__);
	require("engine/header.macro.php");

	$tests = array("0","1","1*60","1*60*60","1*60*60*24","1*60*60*24*30"
			,"1*60+17","1*60*60+17*60+13","1*24*60*60+17*60*60+14*60+11"
			,"1*24*60*60+17*60*60+14*60","1*24*60*60+17*60*60","1*24*60*60"
			,"1*24*60*60+0*60*60+14*60+11","1*24*60*60+17*60*60+0*60+11","1*24*60*60+0*60*60+0*60+11"
		);
	foreach($tests as $test){
		eval('$v='.$test.';');
		echo("DEBUG: ".$test." (".$v."): ".SecsToTime($v)."\n");
	}
	echo("-----------------------------\n");
	foreach($tests as $test){
		eval('$v='.$test.';');
		$v = round($v/3600)*3600;
		echo("DEBUG: ".$test." rounded to hours (".$v."): ".SecsToTime($v,"nap","óra","perc","másodperc","semennyi")."\n");
	}
?>
