<?php
	//------------------------------------------------------------------------
	// Data
	if($User_Level == "MailMaster")
	{
		$query       = "Select * from virtual_domains ORDER by name";
		$doms        = sql($query, "select");
		$Cnt_Domains = count($doms);
	}
	else
	{
		$doms = array();
		for($i = 0; $i < count($AuthData["Domains"]); $i++)
		{
			$TempId = $AuthData["Domains"][$i]["domain_id"];
			$query  = "Select * from virtual_domains where id=$TempId";
			$res    = sql($query, "select");
			$doms[] = $res[0];
		}
		$Cnt_Domains = count($doms);
	}
	$Usrs = array();
	if($DomainID == 0)
	{
		for($i = 0; $i < count($doms); $i++)
		{
			$query  = "Select * from virtual_users where domain_id=".$doms[$i]["id"];
			$res    = sql($query, "select");
			for($j = 0; $j < count($res); $j++)
				$Usrs[] = $res[$j];
		}
	}
	else
	{
		$query = "Select * from virtual_users where domain_id=$DomainID";
		$Usrs  = sql($query, "select");
		$query = "Select * from virtual_domains where id=$DomainID";
		$inf   = sql($query, "select");
		$SelectedDomainName = $inf[0]["name"];
	}
	$Cnt_Users = count($Usrs);
	//------------------------------------------------------------------------
	echo "<table cellspacing='2' cellpadding='2' border='0' width='100%'>";
	echo "	<form name='domainuser' action='mgr_main.php?PHPSESSID=".session_id()."' method='post'>";
	echo "		<input type='hidden' name='aktion' value=''/>";
	echo "		<input type='hidden' name='locationid' value='".$LocationID."'/>";
	echo "		<input type='hidden' name='domainid' value='".$DomainID."'/>";
	echo "		<input type='hidden' name='userid' value='".$DUserID."'/>";
	echo "		<input type='hidden' name='userdelname' value=''/>";
	echo "		<input type='hidden' name='edituserid' value='".$EditDUserID."'/>";
	
	echo "	<tr bgcolor='#cccccc'>";
	echo "		<td valign='top' colspan='2'>";
	echo "			<span class='f13blue'><strong>".GetMessage(39)."</strong></span>";
	echo "		</td>";
	echo "	</tr>";
	echo "	<tr bgcolor='#dddddd'>";
	echo "		<td valign='top' width='20%'>";
	echo "			<span class='f11blue'><strong>".GetMessage(26)."</strong></span>";
	echo "		</td>";
	echo "		<td valign='top' width='80%'>";
	echo "			<span class='f11blue'>$Cnt_Domains</span>";
	echo "		</td>";
	echo "	</tr>";
	echo "	<tr bgcolor='#dddddd'>";
	echo "		<td valign='top'>";
	echo "			<span class='f11blue'><strong>".GetMessage(27)."</strong></span>";
	echo "		</td>";
	echo "		<td valign='top'>";
	echo "			<span class='f11blue'>$Cnt_Users</span>";
	echo "		</td>";
	echo "	</tr>";
	echo "	<tr bgcolor='#ffffff'>";
	echo "		<td valign='top'>";
	echo "			<span class='f11blue'><strong>".GetMessage(40)."</strong></span>";
	echo "		</td>";
	echo "		<td valign='top'>";
	echo "			<span class='f11blue'>";
	echo "				<select name='domainselect' style='width:250px' onchange='SelectDomain()'>";
	if($DomainID == 0)
		echo "<option selected value='0'>All</option>";
	else
		echo "<option value='0'>All</option>";
	for($i = 0; $i < count($doms); $i++)
	{
		$dom = $doms[$i];
		$did = $dom["id"];
		$dns = $dom["name"];
		if($DomainID == $did)
			echo "<option selected value='$did'>$dns</option>";
		else
			echo "<option value='$did'>$dns</option>";
	}
	echo "				</select";
	echo "			</span>";
	echo "		</td>";
	echo "	</tr>";
	
	if($DomainID > 0)
	{
		//--------------------------------------------------
		// Add User
		if($Aktion != "adduser" && $Aktion != "selectmasters")
		{
			echo "	<tr bgcolor='#ffffff'>";
			echo "		<td valign='top' colspan='2'>";
			echo "<span class='f12blue'><a href='#' class='blue' onclick='DomainAdmins()'><img src='img/domainmaster.png' border='0' align='absmiddle'>&nbsp;<strong>".GetMessage(41)."</strong></a></span>";
			echo "		</td>";
			echo "	</tr>";
			echo "	<tr bgcolor='#ffffff'>";
			echo "		<td valign='top' colspan='2'>";
			echo "			<span class='f12blue'><a href='#' class='blue' onclick='AddUser()'><img align='absmiddle' src='img/newdomain.gif' width='20' height='21' border='0'>&nbsp;&nbsp;<strong>".GetMessage(42)."</strong></a></span>";
			echo "		</td>";
			echo "	</tr>";
		}
		else if($Aktion == "selectmasters")
		{
			echo "	<tr bgcolor='#cccccc'>";
			echo "		<td valign='middle' align='center'>";
			echo "			<span class='f12blue'><strong>".GetMessage(43)."</strong>";
			echo "		</td>";
			echo "		<td valign='middle'>";
			echo "			<span class='f12blue'><strong>".GetMessage(44)."</strong>";
			echo "		</td>";
			echo "	</tr>";
			// Mailmaster
			$query    = "Select * from domain_admins where domain_id=0";
			$MMs = sql($query, "select");
			for($i = 0; $i < count($MMs); $i++)
			{
				/*
				$UserID      = $MMs[$i]["user_id"];
				$destination = GetUserEmailbyID($UserID);
				*/
				$UserDomain  = GetUserDomainbyID($UserID);
				$UserDom     = $UserDomain["name"];
				$Username    = GetUserNamebyID($UserID);
				$destination = $Username."@".$UserDom;
				
				echo "	<tr bgcolor='#dddddd'>";
				echo "		<td valign='middle' align='center'>";
				echo "			<input type='Checkbox' name='userid_".$UserID."' checked disabled/>";
				echo "		</td>";
				echo "		<td valign='middle'>";
				echo "			<span class='f12blue'>$destination</strong>";
				echo "		</td>";
				echo "	</tr>";
			}
			// admins
			$query    = "Select * from domain_admins where domain_id=$DomainID";
			$Admins   = sql($query, "select");
			for($i = 0; $i < count($Admins); $i++)
			{
				/*
				$UserID      = $Admins[$i]["user_id"];
                                $destination = GetUserEmailbyID($UserID);

				*/
				$UserDomain  = GetUserDomainbyID($UserID);
				$UserDom     = $UserDomain["name"];
				$Username    = GetUserNamebyID($UserID);
				$destination = $Username."@".$UserDom;
				
				echo "	<tr bgcolor='#dddddd'>";
				echo "		<td valign='middle' align='center'>";
				echo "			<input type='Checkbox' name='userid_".$UserID."' checked/>";
				echo "		</td>";
				echo "		<td valign='middle'>";
				echo "			<span class='f12blue'>$destination</strong>";
				echo "		</td>";
				echo "	</tr>";
			}
			// non-admins same domain
			for($i = 0; $i < count($Usrs); $i++)
			{
				$UserID      = $Usrs[$i]["id"];
                                $destination = GetUserEmailbyID($UserID);

				$query  = "Select * from domain_admins where domain_id > 0 AND domain_id=$DomainID AND user_id=$UserID";
				$ISA    = sql($query, "select");
				if(count($ISA) == 0)
				{
					
					$UserDomain  = GetUserDomainbyID($UserID);
					$UserDom     = $UserDomain["name"];
					$Username    = GetUserNamebyID($UserID);
					$destination = $Username."@".$UserDom;
					
					echo "	<tr bgcolor='#dddddd'>";
					echo "		<td valign='middle' align='center'>";
					echo "			<input type='Checkbox' name='userid_".$UserID."'/>";
					echo "		</td>";
					echo "		<td valign='middle'>";
					echo "			<span class='f12blue'>$destination</strong>";
					echo "		</td>";
					echo "	</tr>";
				}
			}
			echo "	<tr bgcolor='#ffffff'>";
			echo "		<td valign='top' colspan='2'>";
			echo "			<span class='f13blue'><a href='#' class='blue' onclick='SaveDomainMasters()'><img align='absmiddle' src='img/save.gif' width='16' height='16' border='0'>&nbsp;&nbsp;<strong>".GetMessage(45)."</strong></a></span>";
			echo "		</td>";
			echo "	</tr>";
		}
		else if(!$EditDUserID && $Aktion != "selectmasters")
		{
			if(!$Password)
				$Password = CreatePasswort(8);
			echo "	<tr bgcolor='#cccccc'>";
			echo "		<td valign='top' colspan='2'>";
			echo "			<span class='f13blue'><strong>".GetMessage(46)."</strong></span>";
			echo "		</td>";
			echo "	</tr>";
			echo "	<tr bgcolor='#ffffff'>";
			echo "		<td valign='top'>";
			echo "			<span class='f11blue'><strong>".GetMessage(47)."</strong></span>";
			echo "		</td>";
			echo "		<td valign='top'>";
			echo "			<span class='f11blue'><input type='text' style='width:250px' name='username' value='".$UserName."'/><strong>@$SelectedDomainName</strong></span>";
			echo "		</td>";
			echo "	</tr>";
			echo "	<tr bgcolor='#ffffff'>";
			echo "		<td valign='top'>";
			echo "			<span class='f11blue'><strong>".GetMessage(48)."</strong></span>";
			echo "		</td>";
			echo "		<td valign='top'>";
			echo "			<span class='f11blue'><input type='text' style='width:250px' name='password' value='".$Password."'/></span>";
			echo "		</td>";
			echo "	</tr>";
			echo "	<tr bgcolor='#ffffff'>";
			echo "		<td valign='top' colspan='2'>";
			echo "			<span class='f13blue'><a href='#' class='blue' onclick='SaveNewUser()'><img align='absmiddle' src='img/save.gif' width='16' height='16' border='0'>&nbsp;&nbsp;<strong>".GetMessage(49)."</strong></a></span>&nbsp;&nbsp;<span class='f12blue'><input type='Checkbox' name='validation' $valcheck/>&nbsp;".GetMessage(32)."</span>";
			echo "		</td>";
			echo "	</tr>";
			if(count($Error) > 0)
			{
				for($i = 0; $i < count($Error); $i++)
				{
					echo "<tr>";
					echo "	<td valign='top' colspan='2'>";
					echo "		<span class='f13red'><strong>".$Error[$i]."</strong></span>";
					echo "	</td>";
					echo "</tr>";
				}
			}
		}
	}
	echo "	<tr bgcolor='#cccccc'>";
	echo "		<td valign='middle' align='center'>";
	echo "			<span class='f12blue'><strong>".GetMessage(34)."</strong>";
	echo "		</td>";
	echo "		<td valign='middle'>";
	echo "			<span class='f12blue'><strong>".GetMessage(44)."</strong>";
	echo "		</td>";
	echo "	</tr>";
	for($i = 0; $i < count($Usrs); $i++)
	{
		$uid         = $Usrs[$i]["id"];
		$Domain      = GetUserDomainbyID($uid);
		$DomainName  = $Domain["name"];
		$destination = GetUserEmailbyID($uid)."@".$DomainName;
		$ArrInf = explode("@", $destination);
		$source = $ArrInf[0];
		/*
		$Domain      = GetUserDomainbyID($uid);
		$did         = $Domain["id"];
		$DomainName  = $Domain["name"];
		$source      = GetUserNamebyID($uid);
		$destination = $source."@".$DomainName;
		*/
		if($EditDUserID  == $uid)
		{
			$aStr = "<span class='f11blue'><a href='#' class='blue' onclick=\"SaveEditUser($uid, '$source')\"><img align='absmiddle' src='img/save.gif' width='16' height='16' border='0'>&nbsp;&nbsp;<strong>".GetMessage(36)."</strong></a></span>";
			echo "	<tr bgcolor='#dddddd'>";
			echo "		<td valign='middle' align='center'>";
			echo "			<span class='f12blue'>$aStr</strong>";
			echo "		</td>";
			echo "		<td valign='middle'>";
			echo "			<span class='f12blue'><input type='text' style='width:250px' name='source' value='".$source."'/></strong>";
			if(!$CreatePasswordFlag)
				echo "&nbsp;&nbsp;<a href='#' class='blue' onclick=\"SetPasswordFlag()\"><strong>".GetMessage(50)."</strong></a>";
			echo "		</td>";
			echo "	</tr>";
			if($CreatePasswordFlag)
			{
				if(!$Password)
					$Password = CreatePasswort(8);
				echo "	<tr bgcolor='#ffffff'>";
				echo "		<td valign='top'>";
				echo "			<span class='f11blue'><strong>".GetMessage(48)."</strong></span>";
				echo "		</td>";
				echo "		<td valign='top'>";
				echo "			<span class='f11blue'><input type='text' style='width:250px' name='password' value='".$Password."'/></span>";
				echo "		</td>";
				echo "	</tr>";
			}
			if(count($Error) > 0)
			{
				for($j = 0; $j < count($Error); $j++)
				{
					echo "<tr>";
					echo "	<td valign='top' colspan='2'>";
					echo "		<span class='f13red'><strong>".$Error[$j]."</strong></span>";
					echo "	</td>";
					echo "</tr>";
				}
			}
		}
		else
		{
			$aStr = "<span class='f11blue'><a href='#' class='blue' onclick=\"EditUser($uid, '$source')\"><img align='absmiddle' src='img/edit.gif' width='16' height='16' border='0'>&nbsp;&nbsp;<strong>".GetMessage(37)."</strong></a></span>\n";
			$aStr .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class='f11blue'><a href='#' class='blue' onclick=\"DeleteUser($uid, '$source')\"><img align='absmiddle' src='img/pkorb.gif' width='16' height='16' border='0'>&nbsp;&nbsp;<strong>".GetMessage(38)."</strong></a></span>\n";
			echo "	<tr bgcolor='#dddddd'>\n";
			echo "		<td valign='middle' align='center'>\n";
			echo "			$aStr\n";
			echo "		</td>";
			echo "		<td valign='middle'>\n";
			echo "			<span class='f12blue'>$destination</strong>\n";
			echo "		</td>\n";
			echo "	</tr>\n";
		}
	}
	echo "	</form>";
	echo "</table>";
?>
