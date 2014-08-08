<?
	ini_set("mbstring.internal_encoding","UTF-8");
	ini_set("mbstring.func_overload",7);
	ini_set("display_errors", 1);
	error_reporting(E_ALL); // |E_STRICT later

	require_once("engine/config.macro.php");
	require("engine/base.php");
	require("engine/utils.php");
	require("engine/db.php");
	require_once("engine/dblog.php");
	require("engine/users.php");

	require_once("engine/db_config.php");
	$sock=db_ConnectDB(DB_NAME,DB_USER,DB_PASS);
	$_tmp=db_time($sock); define("TIME",$_tmp);
	db_GetVars($sock);
	db_q("SET NAMES utf8;",$sock,"header.macro.php: setting connection to utf8");
?>
