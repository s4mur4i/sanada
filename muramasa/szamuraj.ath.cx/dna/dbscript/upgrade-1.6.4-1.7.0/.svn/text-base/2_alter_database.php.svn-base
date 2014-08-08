#!/usr/bin/php
<?
	if(!defined("__FUNC__"))
		define("__FUNC__","file:".__FILE__);
	require("engine/header.macro.php");

	$q="show tables;";
	$res=db_q($q,$sock,__FUNC__.": selecting tables...");
	while(($table=db_fetch_array($res))){
		$q="alter table ".$table[0]." convert to character set utf8;";
		echo($q." ..."); flush();
		$_starttimeofrun=microtime();
		$_starttimeofrun=explode(" ",$_starttimeofrun);
		$_starttimeofrun=$_starttimeofrun[0]+$_starttimeofrun[1];
		
		db_q($q,$sock,__FUNC__.": altering table ".$table[0].";");
		
		$_endtimeofrun=microtime();
		$_endtimeofrun=explode(" ",$_endtimeofrun);
		$_endtimeofrun=$_endtimeofrun[0]+$_endtimeofrun[1];
		
		$_runtime=$_endtimeofrun-$_starttimeofrun;
		echo(" done. (".$_runtime."s)\n"); flush();
	}
	db_free_result($res);
	db_close($sock);
?>
