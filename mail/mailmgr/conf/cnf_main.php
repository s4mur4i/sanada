<?php
	//-------------------------------------------------------------
	/* Main configuration 
		15.12.2007
		Editor: Peter Gutwein
		Company: GRSoft GmbH
	*/
	//-------------------------------------------------------------
	session_start();
	//-------------------------------------------------------------
	// Session-LanguageID - Default: English
	if($_SESSION["languageid"])
		$grs_app_lang = $_SESSION["languageid"];
	else
	{
		$grs_app_lang = 1;
		$_SESSION["languageid"] = $grs_app_lang;
	}
	//-------------------------------------------------------------
	// Database - Configuration for MySQL 5
	$grs_db_name	 = 'mail';// database name
	$grs_db_host	 = 'db.szamuraj.info';	// database server
	$grs_db_username = 'mail';		// database user
	$grs_db_password = 'Q1w2e3r4';	// database password
	//-------------------------------------------------------------
	// Application 
	// Flag for normal user access
	// Set to 0 to prevent normal users from login
	$app_useraccess  = 1;
	//-------------------------------------------------------------
	// GRSoft - System
	$grs_debugmode  = 0;			// DebugMode
	$grs_debuginfo  = array();		// Debuginfo
?>
