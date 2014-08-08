#!/usr/bin/php
<?
	if(!defined("__FUNC__"))
		define("__FUNC__","file:".__FILE__);
	require("engine/header.macro.php");
	
//----------------------------------------------------------
	function DoSystem($cmd){
		echo($cmd." ..."); flush();
		$_starttimeofrun=microtime();
		$_starttimeofrun=explode(" ",$_starttimeofrun);
		$_starttimeofrun=$_starttimeofrun[0]+$_starttimeofrun[1];
		system($cmd);
		$_endtimeofrun=microtime();
		$_endtimeofrun=explode(" ",$_endtimeofrun);
		$_endtimeofrun=$_endtimeofrun[0]+$_endtimeofrun[1];
		$_runtime=$_endtimeofrun-$_starttimeofrun;
		echo(" done. (".$_runtime."s)\n"); flush();
	}
//----------------------------------------------------------
	$q="show tables;";
	$res=db_q($q,$sock,__FUNC__.": selecting tables...");
	system("rm -f dbtemp.sql");
	system("touch dbtemp.sql");
	if(DB_PASS!="")
		$pparam=" \"-p".DB_PASS."\"";
	else
		$pparam="";
	while(($table=db_fetch_array($res))){
		if($table[0]=="clickevents_archive")
			continue;

		$cmd="mysqldump --opt --skip-extended-insert"
			." -h localhost -u ".DB_USER.$pparam." ".DB_NAME
			." ".$table[0]." >> dbtemp.sql"
		;
		DoSystem($cmd);
	}
	db_free_result($res);
	db_close($sock);
	
	$cmd="cat dbtemp.sql"
		." | replace \"õ\" \"ő\""
		." | replace \"û\" \"ű\""
		." | replace \"Õ\" \"Ő\""
		." | replace \"Û\" \"Ű\""
		." > repaired-dbtemp.sql"
	;
	DoSystem($cmd);

	$cmd="cat repaired-dbtemp.sql | mysql"
		." -h localhost -u ".DB_USER.$pparam." ".DB_NAME
	;
	DoSystem($cmd);
?>
