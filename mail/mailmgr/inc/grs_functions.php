<?php
	/*
		Basic Functions
		Peter Gutwein, 10.07.2007
	*/
	//------------------------------------------------
	// Debugger
	//------------------------------------------------
	function flush_debugger()
	{
		global $grs_debuginfo;
		$grs_debuginfo = array();
	}
	// Add Debug - Info
	function add_debug($titel, $content)
	{
		global $grs_debuginfo;
		$temp    = array();
		$temp[0] = $titel;
		$temp[1] = $content;
		$grs_debuginfo[] = $temp;
	}
	//------------------------------------------------
	// Get language specific text
	function GetMessage($id)
	{
		global $grs_app_lang;
		$query 	= "SELECT * FROM text WHERE mid=$id AND language_id=$grs_app_lang";
		$Set    = sql($query, "select");
		return $Set[0]["text"];
	}
	function GetUserByEmail($Destination)
	{
		$Out  = array();
		$Tarr = explode("@", $Destination);
		if(count($Tarr) < 2)
			return $Out;
		$UName  = $Tarr[0];
		$UDome  = $Tarr[1];
		$Domain = GetUserDomainbyName($UDome);
		if(count($Domain) == 0)
			return $Out;
		$DomainID = $Domain["id"];
		$query    = "Select * from virtual_users where user='$UName' AND domain_id=$DomainID";
		//$query    = "Select * from view_users where email='$Destination'";
		return sql($query, "select");
	}
	function GetUserdatabyID($UserID)
	{
		$query         = "Select * from virtual_users where id=$UserID";
		$res           = sql($query, "select");
		$Userdomain_id = $res[0]["domain_id"];
		$Username      = $res[0]["user"];
		//$Username      = $res[0]["email"];
		$query         = "Select * from virtual_aliases where domain_id=$Userdomain_id AND source='$Username'";
		$res           = sql($query, "select");
		return $res[0];
	}
	function GetUserNamebyID($UserID)
	{
		$query         = "Select * from virtual_users where id=$UserID";
		$res           = sql($query, "select");
		$Username      = $res[0]["user"];
		//$Username      = $res[0]["email"];
		return $Username;
	}
	function GetUserEmailbyID($UserID)
	{
		$query         = "Select * from virtual_users where id=$UserID";
		$res           = sql($query, "select");
		$Username      = $res[0]["user"];
		$Userdomain_id = $res[0]["domain_id"];
		$Useremail = $Username ."@".$Userdomain_id;
		return $Useremail;
	}
	function GetUserDomainbyName($DomainName)
	{
		$query         = "Select * from virtual_domains where name='$DomainName'";
		$res           = sql($query, "select");
		if(count($res) == 1)
			return $res[0];
		return array();
	}
	function GetUserDomainbyID($UserID)
	{
		$query         = "Select * from virtual_users where id=$UserID";
		$res           = sql($query, "select");
		$DomID         = $res[0]["domain_id"];
		return GetDomainbyID($DomID);
	}
	function GetDomainbyID($DomID)
	{
		$query         = "Select * from virtual_domains where id=$DomID";
		$res           = sql($query, "select");
		return $res[0];
	}
	function GetUserIDbyAliasID($aid)
	{
		$query = "Select * from virtual_aliases where id=$aid";
		$res   = sql($query, "select");
		$Userdomain_id = $res[0]["domain_id"];
		$Username      = $res[0]["source"];
		$query         = "Select * from virtual_users where domain_id=$Userdomain_id AND user='$Username'";
		$res           = sql($query, "select");
		return $res[0]["id"];
	}
	//------------------------------------------------
	// Create password
	function CreatePasswort($Laenge)
	{
		$Passwort = "";
		$Buchstaben    = array("a", "b", "c", "d", "e", "f", "g", "h", "k", "m", "n", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");
		$Buchstaben_2  = array("a", "b", "c", "d", "e", "f", "g", "h", "k", "m", "n", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");
		$Zahlen        = array("2", "3", "4", "5", "6", "7", "8", "9");
		for($i=0, $Passwort=""; strlen($Passwort) < $Laenge; $i++)
		{
			if(rand(0, 2)==0 && isset($Buchstaben))
			{
			   $Passwort.=$Buchstaben[rand(0, count($Buchstaben))];
			}
			elseif(rand(0, 2)==1 && isset($Zahlen))
			{
			   $Passwort.=$Zahlen[rand(0, count($Zahlen))];
			}
			elseif(rand(0, 2)==1 && isset($Buchstaben_2))
			{
			   $Passwort.=strtoupper($Buchstaben_2[rand(0, count($Buchstaben_2))]);
			}
		}
		return $Passwort;
	}
?>
