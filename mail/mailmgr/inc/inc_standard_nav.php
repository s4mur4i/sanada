<?php
	echo "<table cellspacing='2' cellpadding='2' border='0' width='100%'>";
	echo "	<tr bgcolor='#bbbbbb'>";
	echo "		<td valign='middle'>";
	if($LocationID == 1)
		echo "<span class='f13white'><strong>Info</strong></span>";
	else
		echo "<span class='f13blue'><a href='#' onclick='NavigateTo(1)' class='blue'><strong>Info</strong></a></span>";
	echo "		</td>";
	echo "	</tr>";
	if($User_Level == "MailMaster")
	{
		echo "	<tr bgcolor='#bbbbbb' valign='middle'>";
		echo "		<td valign='middle'>";
		if($LocationID == 2)
			echo "<span class='f13white'><strong>".GetMessage(23)."</strong></span>";
		else
			echo "<span class='f13blue'><a href='#' onclick='NavigateTo(2)' class='blue'><strong>".GetMessage(23)."</strong></a></span>";
		echo "		</td>";
		echo "	</tr>";
	}
	if($User_Level == "MailMaster" || $User_Level == "DomainMaster")
	{
		echo "	<tr bgcolor='#bbbbbb'>";
		echo "		<td valign='middle'>";
		if($LocationID == 3)
			echo "<span class='f13white'><strong>".GetMessage(24)."</strong></span>";
		else
			echo "<span class='f13blue'><a href='#' onclick='NavigateTo(3)' class='blue'><strong>".GetMessage(24)."</strong></a></span>";
		echo "		</td>";
		echo "	</tr>";
	}
	echo "	<tr bgcolor='#bbbbbb' valign='middle'>";
	echo "		<td valign='middle'>";
	if($LocationID == 5)
		echo "<span class='f13white'><strong>".GetMessage(62)."</strong></span>";
	else
		echo "<span class='f13blue'><a href='#' onclick='NavigateTo(5)' class='blue'><strong>".GetMessage(62)."</strong></a></span>";
	echo "		</td>";
	echo "	</tr>";
	echo "	<tr bgcolor='#bbbbbb'>";
	echo "		<td valign='middle'>";
	echo "			<span class='f13blue'><a href='#' onclick='NavigateTo(4)' class='blue'><strong>Log out</strong></a></span>";
	echo "		</td>";
	echo "	</tr>";
	echo "</table>";
?>
