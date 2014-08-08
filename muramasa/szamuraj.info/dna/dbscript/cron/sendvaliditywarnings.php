#!/usr/bin/php
<?
	if(!defined("__FUNC__"))
		define("__FUNC__","file:".__FILE__);
	require("engine/header.macro.php");
	sys_log(__FUNC__." started; PID: ".getmypid());
	require_once("engine/computers_admin.php");
	$limits = array(1,3,7);
	for($i=0; $i<count($limits); ++$i) // FUCK YOU: https://bugs.php.net/bug.php?id=29992
		$limits[$i] *= 24*60*60;
	
	$computers=ReadComputersByValidityState($sock,VALIDITYSTATE_VALID);
	foreach($computers as $computer){
		$ttl = $computer->ValidUntilD - TIME;
		$tfs = $computer->ValidUntilD - $computer->LastValidityWarningD;
		// echo("DEBUG: namegin: ".$c->NameBegin."; ttl: ".SecsToTime($ttl)."; tfs: ".SecsToTime($tfs)."\n");
		foreach($limits as $limit){
			if($ttl <= $limit && $tfs > $limit){
				SendValidityWarning($sock,$computer,$limit,$ttl);
				// echo("DEBUG: CHECKPOINT: limit: ".SecstoTime($limit,"nap","óra","perc","másodperc","semennyi")."\n");
				break;
			}
		}
	}
	sys_log(__FUNC__." finished; PID: ".getmypid());
?>
