<?php
	if($User_Level == "DomainUser")
	{
		$DomainID   = $AuthData["Domains"][0];
		$EditUserID = $AuthData["UserID"];
		$query = "Select * from virtual_domains where id=$DomainID";
		$inf   = sql($query, "select");
		$SelectedDomainName = $inf[0]["name"];
	}
	//------------------------------------------------------------------------
	// Data
	if($User_Level == "MailMaster")
	{
		$query       = "Select * from virtual_domains ORDER by name";
		$doms        = sql($query, "select");
		$Cnt_Domains = count($doms);
	}
	else if($User_Level == "DomainMaster")
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
	else
		$Cnt_Domains = 1;
	
	//------------------------------------------------------------------------
	echo "<table cellspacing='2' cellpadding='2' border='0' width='100%'>";
	echo "	<form name='edituser' action='mgr_main.php?PHPSESSID=".session_id()."' method='post'>";
	echo "		<input type='hidden' name='aktion' value=''/>";
	echo "		<input type='hidden' name='locationid' value='".$LocationID."'/>";
	echo "		<input type='hidden' name='domainid' value='".$DomainID."'/>";
	echo "		<input type='hidden' name='edituserid' value='".$EditUserID."'/>";
	echo "		<input type='hidden' name='editaliasid' value='".$EditAliasAccount."'/>";
	
	if($User_Level == "MailMaster" || $User_Level == "DomainMaster")
	{
		echo "	<tr bgcolor='#dddddd'>";
		echo "		<td valign='top' width='30%'>";
		echo "			<img src='img/domain.gif' align='absmiddle'>&nbsp;<span class='f11blue'><strong>".GetMessage(40)."</strong></span>";
		echo "		</td>";
		echo "		<td valign='top' width='70%'>";
		echo "			<span class='f11blue'>";
		echo "				<select name='domainselect' style='width:250px' onchange='SelectUserDomain()'>";
		if($DomainID == 0)
			echo "<option selected value='0'>---</option>";
		else
			echo "<option value='0'>---</option>";
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
	}
	if($DomainID > 0 && ($User_Level == "MailMaster" || $User_Level == "DomainMaster"))
	{
		$query = "Select * from virtual_domains where id=$DomainID";
		$inf   = sql($query, "select");
		$SelectedDomainName = $inf[0]["name"];
		if($User_Level == "MailMaster" || $User_Level == "DomainMaster")
		{
			$query  = "Select * from virtual_users where domain_id=$DomainID";
			$Usrs   = sql($query, "select");
			echo "	<tr bgcolor='#dddddd'>";
			echo "		<td valign='top'>";
			echo "			<img src='img/user.png' align='absmiddle'>&nbsp;<span class='f11blue'><strong>".GetMessage(68)."</strong></span>";
			echo "		</td>";
			echo "		<td valign='top'>";
			echo "			<span class='f11blue'>";
			echo "				<select name='userselect' style='width:250px' onchange='SelectUser()'>";
			echo "					<option value='0'>---</option>";
			for($i = 0; $i < count($Usrs); $i++)
			{
				$usr    = $Usrs[$i];
				$uid    = $usr["id"];
				$source = $usr["user"];
				if($EditUserID == $uid)
					echo "<option selected value='$uid'>$source</option>";
				else
					echo "<option value='$uid'>$source</option>";
			}
			echo "				</select";
			echo "			</span>";
			echo "		</td>";
			echo "	</tr>";
		}
	}

	if($EditUserID > 0)
	{
		$Userdata    = GetUserdatabyID($EditUserID);
		$aid         = $Userdata["id"];
		$did         = $Userdata["domain_id"];
		if(!$Newusersource)
			$source = GetUserNamebyID($EditUserID);
		else
			$source = $Newusersource;
		//$destination = $Userdata["destination"];
		$destination = $source."@".$SelectedDomainName;
		//$destination = $source;
		
		$query = "Select * from virtual_aliases where domain_id=$DomainID and source='$source' order by id";
		$alis  = sql($query, "select");
		
		$query    = "Select * from virtual_aliases where domain_id=$DomainID and destination='$destination' order by id";
		$realalis = sql($query, "select");

		if(!$EditUserAccountFlag)
			$aStr = "<span class='f11blue'><a href='#' class='blue' onclick=\"EditUserAccount($EditUserID)\"><img align='absmiddle' src='img/edit.gif' width='16' height='16' border='0'>&nbsp;&nbsp;<strong>".GetMessage(37)."</strong></a></span>";
		else
			$aStr = "<span class='f11blue'><a href='#' class='blue' onclick=\"SaveEditUserAccount($EditUserID)\"><img align='absmiddle' src='img/save.gif' width='16' height='16' border='0'>&nbsp;&nbsp;<strong>".GetMessage(36)."</strong></a></span>";
		
		echo "	<tr>";
		echo "		<td colspan='2'>";
		echo "			<table cellspacing='5' cellpadding='5' border='0' width='100%'>";
		echo "				<tr bgcolor='#cccccc'>";
		echo "					<td colspan='4'>";
		echo "						<img src='img/user.png' align='absmiddle'>&nbsp;<span class='f12blue'><strong>$source".GetMessage(69)."$SelectedDomainName</strong></span>";
		echo "					</td>";
		echo "				</tr>";
		echo "				<tr bgcolor='#dddddd'>";
		echo "					<td align='center' width='20%'>";
		echo "						<span class='f11blue'><strong>".GetMessage(34)."</strong></span>";
		echo "					</td>";
		echo "					<td align='center' width='5%'>";
		echo "						<span class='f11blue'><strong>Id</strong></span>";
		echo "					</td>";
		echo "					<td width='25%'>";
		echo "						<span class='f11blue'><strong>".GetMessage(47)."</strong></span>";
		echo "					</td>";
		echo "					<td width='50%'>";
		echo "						<span class='f11blue'><strong>".GetMessage(77)."</strong></span>";
		echo "					</td>";
		echo "				</tr>";
		if(!$EditUserAccountFlag)
		{
			echo "				<tr bgcolor='#dddddd'>";
			echo "					<td align='center'>";
			echo "						<span class='f11blue'>$aStr</span>";
			echo "					</td>";
			echo "					<td align='center'>";
			echo "						<span class='f11blue'>$EditUserID</span>";
			echo "					</td>";
			echo "					<td>";
			echo "						<span class='f11blue'>$source</span>";
			echo "					</td>";
			echo "					<td>";
			echo "						<span class='f11blue'>$destination</span>";
			echo "					</td>";
			echo "				</tr>";
		}
		else
		{
			echo "				<tr bgcolor='#dddddd'>";
			echo "					<td align='center'>";
			echo "						<span class='f11blue'>$aStr</span>";
			echo "					</td>";
			echo "					<td align='center'>";
			echo "						<span class='f11blue'>$EditUserID</span>";
			echo "					</td>";
			echo "					<td>";
			echo "						<span class='f11blue'><input type='text' style='width:250px' name='source' value='".$source."'/></span>";
			echo "					</td>";
			echo "					<td>";
			echo "						<span class='f11blue'>$destination</span>";
			echo "					</td>";
			echo "				</tr>";
			if(!$CreatePasswordFlag)
			{
				echo "				<tr bgcolor='#cccccc'>";
				echo "					<td colspan='4'>";
				echo "						<span class='f11blue'><a href='#' class='blue' onclick=\"SetPasswordFlag2()\"><strong>".GetMessage(50)."</strong></a></span>";
				echo "					</td>";
				echo "				</tr>";
			}
			else
			{
				echo "				<tr bgcolor='#cccccc'>";
				echo "					<td colspan='4'>";
				echo "						<span class='f11blue'><strong>".GetMessage(48)."</strong> <input type='text' style='width:250px' name='password' value='".CreatePasswort(8)."'/></span>";
				echo "					</td>";
				echo "				</tr>";
			}
		}
		echo "				<tr bgcolor='#cccccc'>";
		echo "					<td colspan='4'>";
		echo "						<img src='img/forward.png' align='absmiddle' border='0'>&nbsp;<span class='f11blue'><strong>".GetMessage(71)."$source".GetMessage(69)."$SelectedDomainName</strong></span>";
		echo "					</td>";
		echo "				</tr>";
		echo "				<tr bgcolor='#dddddd'>";
		echo "					<td align='center' width='15%'>";
		echo "						<span class='f11blue'><strong>".GetMessage(34)."</strong></span>";
		echo "					</td>";
		echo "					<td align='center' width='5%'>";
		echo "						<span class='f11blue'><strong>Id</strong></span>";
		echo "					</td>";
		echo "					<td width='30%'>";
		echo "						<span class='f11blue'><strong>".GetMessage(75)."</strong></span>";
		echo "					</td>";
		echo "					<td width='50%'>";
		echo "						<span class='f11blue'><strong>".GetMessage(76)."</strong></span>";
		echo "					</td>";
		echo "				</tr>";
		for($i = 0; $i < count($alis); $i++)
		{
			$aliid          = $alis[$i]["id"];
			$alidestination = $alis[$i]["destination"];
			if($EditAliasAccount == $aliid)
			{
				$bStr = "<a href='#' class='blue' onclick=\"SaveEditUserAlias($aliid)\"><img align='absmiddle' src='img/save.gif' width='16' height='16' border='0'>&nbsp;&nbsp;<strong>".GetMessage(36)."</strong></a>";
				echo "				<tr bgcolor='#dddddd'>";
				echo "					<td align='center'>";
				echo "						<span class='f11blue'>$bStr</span>";
				echo "					</td>";
				echo "					<td align='center'>";
				echo "						<span class='f11blue'>$aliid</span>";
				echo "					</td>";
				echo "					<td>";
				echo "						<span class='f11blue'>$source</span>";
				echo "					</td>";
				echo "					<td>";
				echo "						<span class='f11blue'><input type='text' style='width:250px' name='newdestination' value='".$alidestination."'/></span>";
				echo "					</td>";
				echo "				</tr>";
			}
			else
			{
				$bStr = "<span class='f11blue'><a href='#' class='blue' onclick=\"EditUserAlias($aliid)\"><img align='absmiddle' src='img/edit.gif' width='16' height='16' border='0'>&nbsp;&nbsp;<strong>".GetMessage(37)."</strong></a></span>";
				$bStr .= "&nbsp;&nbsp;&nbsp;<span class='f11blue'><a href='#' class='blue' onclick=\"DeleteUserAlias($aliid)\"><img align='absmiddle' src='img/pkorb.gif' width='16' height='16' border='0'>&nbsp;&nbsp;<strong>".GetMessage(38)."</strong></a></span>";
				echo "				<tr bgcolor='#dddddd'>";
				echo "					<td align='center'>";
				echo "						<span class='f11blue'>$bStr</span>";
				echo "					</td>";
				echo "					<td align='center'>";
				echo "						<span class='f11blue'>$aliid</span>";
				echo "					</td>";
				echo "					<td>";
				echo "						<span class='f11blue'>$source</span>";
				echo "					</td>";
				echo "					<td>";
				echo "						<span class='f11blue'>$alidestination</span>";
				echo "					</td>";
				echo "				</tr>";
			}
		}
		if($Aktion != "addalias")
		{
			echo "<tr bgcolor='#dddddd'>";
			echo "	<td valign='top' colspan='4'>";
			echo "		<span class='f11blue'><a href='#' class='blue' onclick='AddAlias()'><img src='img/forwardnew.png' align='absmiddle' border='0'>&nbsp;<strong>".GetMessage(78)."</strong></a></span>";
			echo "	</td>";
			echo "</tr>";
		}
		else
		{
			echo "<tr bgcolor='#cccccc'>";
			echo "	<td colspan='4'>";
			echo "		<span class='f11blue'><strong>".GetMessage(79)."</strong>";
			echo "	</td>";
			echo "</tr>";
			echo "<tr bgcolor='#dddddd'>";
			echo "	<td colspan='4'>";
			echo "		<span class='f11blue'><strong>".GetMessage(85)."</strong>";
			echo "		&nbsp;&nbsp;<span class='f11blue'><input type='text' style='width:250px' name='newdestination' value='".$newdestination."'/></span>";
			echo "	</td>";
			echo "</tr>";
			echo "<tr bgcolor='#dddddd'>";
			echo "	<td valign='top' colspan='4'>";
			echo "		<span class='f11blue'><a href='#' class='blue' onclick=\"SaveNewAlias()\"><img align='absmiddle' src='img/save.gif' width='16' height='16' border='0'>&nbsp;&nbsp;<strong>".GetMessage(80)."</strong></a></span>";
			echo "	</td>";
			echo "</tr>";
		}
		echo "				<tr bgcolor='#cccccc'>";
		echo "					<td colspan='4'>";
		echo "						<img src='img/alias.png' align='absmiddle' border='0'>&nbsp;<span class='f11blue'><strong>".GetMessage(86)."$source".GetMessage(87)."$SelectedDomainName</strong></span>";
		echo "					</td>";
		echo "				</tr>";
		echo "				<tr bgcolor='#dddddd'>";
		echo "					<td align='center' width='15%'>";
		echo "						<span class='f11blue'><strong>".GetMessage(34)."</strong></span>";
		echo "					</td>";
		echo "					<td align='center' width='5%'>";
		echo "						<span class='f11blue'><strong>Id</strong></span>";
		echo "					</td>";
		echo "					<td width='30%'>";
		echo "						<span class='f11blue'><strong>".GetMessage(81)."</strong></span>";
		echo "					</td>";
		echo "					<td width='50%'>";
		echo "						<span class='f11blue'><strong>".GetMessage(82)."</strong></span>";
		echo "					</td>";
		echo "				</tr>";
		for($i = 0; $i < count($realalis); $i++)
		{
			$aliid     = $realalis[$i]["id"];
			$alisource = $realalis[$i]["source"];
			if(!$alisource || $alisource == "")
				$alisource = "<span class='f11red'><strong>CatchAll - Alias</strong></span>";
			if($EditRealAliasAccount == $aliid)
			{
				$bStr = "<a href='#' class='blue' onclick=\"SaveEditUserRealAlias($aliid)\"><img align='absmiddle' src='img/save.gif' width='16' height='16' border='0'>&nbsp;&nbsp;<strong>".GetMessage(36)."</strong></a>";
				echo "				<tr bgcolor='#dddddd'>";
				echo "					<td align='center'>";
				echo "						<span class='f11blue'>$bStr</span>";
				echo "					</td>";
				echo "					<td align='center'>";
				echo "						<span class='f11blue'>$aliid</span>";
				echo "					</td>";
				echo "					<td>";
				echo "						<span class='f11blue'><input type='text' style='width:250px' name='alisource' value='".$alisource."'/></span>";
				echo "					</td>";
				echo "					<td>";
				echo "						<span class='f11blue'>$destination</span>";
				echo "					</td>";
				echo "				</tr>";
			}
			else
			{
				$bStr = "<span class='f11blue'><a href='#' class='blue' onclick=\"EditUserRealAlias($aliid)\"><img align='absmiddle' src='img/edit.gif' width='16' height='16' border='0'>&nbsp;&nbsp;<strong>".GetMessage(37)."</strong></a></span>";
				$bStr .= "&nbsp;&nbsp;&nbsp;<span class='f11blue'><a href='#' class='blue' onclick=\"DeleteUserRealAlias($aliid)\"><img align='absmiddle' src='img/pkorb.gif' width='16' height='16' border='0'>&nbsp;&nbsp;<strong>".GetMessage(38)."</strong></a></span>";
				echo "				<tr bgcolor='#dddddd'>";
				echo "					<td align='center'>";
				echo "						<span class='f11blue'>$bStr</span>";
				echo "					</td>";
				echo "					<td align='center'>";
				echo "						<span class='f11blue'>$aliid</span>";
				echo "					</td>";
				echo "					<td>";
				echo "						<span class='f11blue'>$alisource</span>";
				echo "					</td>";
				echo "					<td>";
				echo "						<span class='f11blue'>$destination</span>";
				echo "					</td>";
				echo "				</tr>";
			}
		}
		if($Aktion != "addrealalias")
		{
			echo "<tr bgcolor='#dddddd'>";
			echo "	<td valign='top' colspan='4'>";
			echo "		<span class='f11blue'><a href='#' class='blue' onclick='AddRealAlias()'><img src='img/aliasnew.png' align='absmiddle' border='0'>&nbsp;<strong>".GetMessage(72)."</strong></a></span>";
			echo "	</td>";
			echo "</tr>";
		}
		else
		{
			echo "<tr bgcolor='#cccccc'>";
			echo "	<td colspan='4'>";
			echo "		<span class='f11blue'><strong>".GetMessage(83)."</strong>";
			echo "	</td>";
			echo "</tr>";
			echo "<tr bgcolor='#dddddd'>";
			echo "	<td colspan='4'>";
			echo "		<span class='f11blue'><strong>".GetMessage(84)."</strong>";
			echo "		&nbsp;&nbsp;<span class='f11blue'><input type='text' style='width:250px' name='alisource' value=''/> for $destination</span>";
			echo "	</td>";
			echo "</tr>";
			echo "<tr bgcolor='#dddddd'>";
			echo "	<td valign='top' colspan='4'>";
			echo "		<span class='f11blue'><a href='#' class='blue' onclick=\"SaveNewRealAlias()\"><img align='absmiddle' src='img/save.gif' width='16' height='16' border='0'>&nbsp;&nbsp;<strong>".GetMessage(74)."</strong></a></span>";
			echo "	</td>";
			echo "</tr>";
		}
		echo "			</table>";
		echo "		</td>";
		echo "	</tr>";
		
		
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
	echo "	</form>";
	echo "</table>";
?>
