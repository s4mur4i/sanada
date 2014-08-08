<?php
	//------------------------------------------------------------------------
	// Data
	$query       = "Select * from virtual_domains ORDER by name";
	$doms        = sql($query, "select");
	$Cnt_Domains = count($doms);
	$query       = "Select * from virtual_aliases";
	$usrs        = sql($query, "select");
	$Cnt_Users   = count($usrs);
	//------------------------------------------------------------------------
	echo "<table cellspacing='2' cellpadding='2' border='0' width='100%'>";
	echo "	<form name='domains' action='mgr_main.php?PHPSESSID=".session_id()."' method='post'>";
	echo "		<input type='hidden' name='aktion' value=''/>";
	echo "		<input type='hidden' name='locationid' value='".$LocationID."'/>";
	echo "		<input type='hidden' name='domainid' value='".$DomainID."'/>";
	echo "		<input type='hidden' name='editdomainid' value='".$EditDomainID."'/>";
	
	echo "	<tr bgcolor='#cccccc'>";
	echo "		<td valign='top' colspan='2'>";
	echo "			<span class='f13blue'><strong>".GetMessage(25)."</strong></span>";
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
	//--------------------------------------------------
	// Add domain
	if($Aktion != "adddomain")
	{
		echo "	<tr bgcolor='#ffffff'>";
		echo "		<td valign='top' colspan='2'>";
		echo "			<span class='f12blue'><a href='#' class='blue' onclick='AddDomain()'><img align='absmiddle' src='img/newdomain.gif' width='20' height='21' border='0'>&nbsp;&nbsp;<strong>".GetMessage(28)."</strong></a></span>";
		echo "		</td>";
		echo "	</tr>";
	}
	else
	{
		echo "	<tr bgcolor='#cccccc'>";
		echo "		<td valign='top' colspan='2'>";
		echo "			<span class='f13blue'><strong>".GetMessage(29)."</strong></span>";
		echo "		</td>";
		echo "	</tr>";
		echo "	<tr bgcolor='#ffffff'>";
		echo "		<td valign='top'>";
		echo "			<span class='f11blue'><strong>".GetMessage(30)."</strong></span>";
		echo "		</td>";
		echo "		<td valign='top'>";
		echo "			<span class='f11blue'><input type='text' style='width:350px' name='fqdn' value='".$FQDN."'/>&nbsp;&nbsp;e.g.: example.com</span>";
		echo "		</td>";
		echo "	</tr>";
		echo "	<tr bgcolor='#ffffff'>";
		echo "		<td valign='top' colspan='2'>";
		echo "			<span class='f13blue'><a href='#' class='blue' onclick='SaveNewDomain()'><img align='absmiddle' src='img/save.gif' width='16' height='16' border='0'>&nbsp;&nbsp;<strong>".GetMessage(31)."</strong></a></span>&nbsp;&nbsp;<span class='f12blue'><input type='Checkbox' name='validation' $valcheck/>&nbsp;".GetMessage(32)."</span>";
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
	//--------------------------------------------------
	// List domains
	echo "	<tr bgcolor='#cccccc'>";
	echo "		<td valign='top' colspan='2'>";
	echo "			<span class='f13blue'><strong>".GetMessage(33)."</strong>";
	echo "		</td>";
	echo "	</tr>";
	echo "	<tr bgcolor='#cccccc'>";
	echo "		<td valign='middle' align='center'>";
	echo "			<span class='f12blue'><strong>".GetMessage(34)."</strong>";
	echo "		</td>";
	echo "		<td valign='middle'>";
	echo "			<span class='f12blue'><strong>".GetMessage(35)."</strong>";
	echo "		</td>";
	echo "	</tr>";
	for($i = 0; $i < count($doms); $i++)
	{
		$did  = $doms[$i]["id"];
		$dna  = $doms[$i]["name"];
		if($EditDomainID  == $did)
		{
			$aStr = "<span class='f11blue'><a href='#' class='blue' onclick=\"SaveEditDomain($did, '$dna')\"><img align='absmiddle' src='img/save.gif' width='16' height='16' border='0'>&nbsp;&nbsp;<strong>".GetMessage(36)."</strong></a></span>";
			echo "	<tr bgcolor='#dddddd'>";
			echo "		<td valign='middle' align='center'>";
			echo "			<span class='f12blue'>$aStr</strong>";
			echo "		</td>";
			echo "		<td valign='middle'>";
			echo "			<span class='f12blue'><input type='text' style='width:350px' name='fqdn' value='".$dna."'/></strong>";
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
		else
		{
			$aStr = "<span class='f11blue'><a href='#' class='blue' onclick=\"EditDomain($did, '$dna')\"><img align='absmiddle' src='img/edit.gif' width='16' height='16' border='0'>&nbsp;&nbsp;<strong>".GetMessage(37)."</strong></a></span>";
			$aStr .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class='f11blue'><a href='#' class='blue' onclick=\"DeleteDomain($did, '$dna')\"><img align='absmiddle' src='img/pkorb.gif' width='16' height='16' border='0'>&nbsp;&nbsp;<strong>".GetMessage(38)."</strong></a></span>";
			echo "	<tr bgcolor='#dddddd'>";
			echo "		<td valign='middle' align='center'>";
			echo "			<span class='f12blue'>$aStr</strong>";
			echo "		</td>";
			echo "		<td valign='middle'>";
			echo "			<span class='f12blue'>$dna</strong>";
			echo "		</td>";
			echo "	</tr>";
		}
	}
	echo "	</form>";
	echo "</table>";
?>
