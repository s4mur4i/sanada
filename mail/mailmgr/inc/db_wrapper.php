<?php
	//---------------------------------------------
	// Database connection and sql-wrapper
	// Definitions in cnf_main.php
	//---------------------------------------------
	function dbconnect()
	{
		global $connexion, $grs_db_host, $grs_db_username, $grs_db_password, $grs_db_name;
		$connexion     = mysql_connect($grs_db_host, $grs_db_username, $grs_db_password) or die("Could not establish database server connection. Check username and password");
		$connexionbase = mysql_select_db( $grs_db_name ) or die("Could not establish database connection. Check username and password");
		return(($connexion && $connexionbase));
	}
	//---------------------------------------------
	// Verbindungsaufbau
	$Connectresult = dbconnect();
	//---------------------------------------------
	// SQL - Wrapper
	function sql($query, $operation)
	{
		global $grs_debugmode;
		if($grs_debugmode == 1)
			$result = mysql_query($query) or die("SQL-Error: ".mysql_error()."<br>Query: ".$query);
		else
			$result = mysql_query($query) or die("SQL-Error. Please contact the MailMaster");	
		switch($operation)
		{
			case "select": 
				$ret    = array();
				$lines  = mysql_num_rows($result);
				if( $lines == 0 )
					return $ret;			
				else
				{
					$x = 0;
					while($row = mysql_fetch_array($result, MYSQL_BOTH))
					{
						$ret[$x] = $row;
						$x++;
					}
					return $ret;
				}
			case "insertwithID":
				$InsertID = mysql_insert_id();
				return $InsertID;
			case "insert":
				return $result;
			case "update":
				return $result;
			case "delete":
				return $result;
		}
	}
	//---------------------------------------------
?>