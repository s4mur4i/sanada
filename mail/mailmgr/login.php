<?php
	/*
	Postix Managerinterface for handling virtual domains and users
	Based on the installation of ISPmail tutorial for Debian Lenny
	after the instructions of
	howto: ISPmail tutorial for Debian Lenny
	http://workaround.org/ispmail/lenny
	Author: Dipl.-Inform. Christoph Haas
	--------------------------------------------
	Code written by Peter Gutwein, GRSoft GmbH, peter.gutwein@grsoft.ch, 15.12.2007
	Copyrights: GNU/GPL
	I am happy about your feedback!
	--------------------------------------------
	What this script does is:
	1. MailMaster can delete (recursive), edit (recursive) and create virtual domains in the database
	2. MailMaster can delete, edit and create (with password support) Domain Administrators in the database
	3. DomainMaster can delete, edit and create (with password support) mail user of his own domain in the database
	--------------------------------------------
	// Installation notices
	--------------------------------------------
	1. upload package to your web - directory
	2. unpack package
	3. Start a webrowser and go to install.php
	4. Follow the instructions
	5. Hopefully be happy with it
	--------------------------------------------
	*/
	//-------------------------------------
	// includes
	require_once('./conf/cnf_main.php');
	require_once('./inc/db_wrapper.php');
	require_once('./inc/grs_functions.php');
	//--------------------------------------
	// Debugger
	flush_debugger(); // debug-array flush
	session_start();
	$Error = array();
	$_SESSION["grs_authentification"] = array();
	//-------------------------------------
	// Wurde die Sprache verändert?
	if($_POST["newlang"])
	{
		$grs_app_lang = intval($_POST["newlang"]);
		$_SESSION["languageid"] = $grs_app_lang;
	}
	//-------------------------------------
	if($_POST["aktion"] == "logintry")
	{
		$Destination  = $_POST["loginname"];
		if($Destination)
		{
			$LoginUser = GetUserByEmail($Destination);		
			//if(count($LoginUser) > 0)
			//{
				$Password = $_POST["passwd"];
				if($Password)
				{
					//$Source   = $LoginUser[0]["user"];
					$DomainID = $LoginUser[0]["domain_id"];
					$query  = "Select * from view_users where email='$Destination' AND password='".md5($Password)."'";
					$res    = sql($query, "select");
					if(count($res) > 0)
					{
						$UserID  = $res[0]["id"];
						//$query   = "Select * from domain_admins where user_id=$UserID ORDER BY domain_id ASC";
						$res     = sql($query, "select");
						$AuthSet = array();
						$AuthSet["UserID"]  = $UserID;
						$AuthSet["Email"]   = $Destination;
						if(count($res) > 0)
						{
							$AuthSet["Domains"] = $res;
							if($res[0]["domain_id"] == 0)
								$AuthSet["Level"] = "MailMaster";
							else
								$AuthSet["Level"] = "DomainMaster";
						}
						else
						{
							if($app_useraccess == 1)
							{
								$AuthSet["Domains"] = array();
								$AuthSet["Domains"][] = $DomainID;
								$AuthSet["Level"] = "DomainUser";
							}
							else
								$Error[] = GetMessage(58);
						}
						//--------------------------------------
						$_SESSION["grs_authentification"] = $AuthSet;
						//--------------------------------------
					}
					else
						$Error[] = GetMessage(59);
				}
				else
					$Error[] = GetMessage(60);
			//}
			//else
			//	$Error[] = GetMessage(58);
		}
		else
			$Error[] = GetMessage(61);
	}
	if(count($Error) == 0 && count($_SESSION["grs_authentification"]) > 0)
		$LoginFlag = 1;
	
	 $page_URL = "login.php";
	
?>
<html>
	<head>
		<META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">
		<title>Mail-Manager Login</title>
		<link rel="stylesheet" type="text/css" href="css/frm_styles.css">
		<script language="JavaScript">
			function ChangeLanguage(lid)
			{
				document.forms.langswitch.newlang.value = lid;
				document.forms.langswitch.submit();
			}
		</script>
	</head>
	<body bgColor='#ffffff' bottomMargin=0 leftMargin='0' topMargin='0' rightMargin='0' marginwidth='0' marginheight='0'>
		<form name='gomaster' action='mgr_main.php?PHPSESSID=<?php echo session_id()?>' method='post'>
			<input type="hidden" name="aktion" value="registered"/>
		</form>
		<form name="langswitch" id="langswitch" action="login.php" method="post">
			<input type="hidden" name="newlang" id="newlang" value=""/>
		</form>
		<?php
			if($LoginFlag == 1)
			{
				echo "<script language='JavaScript'>";
				echo "	document.forms.gomaster.submit();";
				echo "</script>";
			}
		?>
		<table cellspacing="0" cellpadding="0" border="0" align="center" width="100%" >
			<tr>
				<td valign="top" align="center">
					<img src="img/grslogo.gif"><br><span class="f10blue">Version 2.0 (Debian Lenny)</span>
				</td>
			</tr>
			<tr>
				<td valign="top" align="center">
					<img src="img/spacer.gif" width="1" height="5">
				</td>
			</tr>
			<tr>
				<td valign="top">
					<table cellspacing="5" cellpadding="5" border="0" width="100%">
						<tr>
							<td valign="top" align="right" bgcolor="#bbbbbb" colspan="2">
								<?php include("inc/inc_languages.php")?>
							</td>
						</tr>
						<form name='logindlg' action='login.php' method='post'>
							<input type="hidden" name="aktion" value="logintry"/>
						<tr align="center">
							<td valign="top" align="right" width="40%">
								<span class="f13blue"><?php echo GetMessage(1)?></span>
							</td>
							<td valign="top" align="left" width="60%">
								<span class="f13blue"><input style='width:250px' type='text' name='loginname' value='<?php echo $_POST["loginname"]?>'/></span>
							</td>
						</tr>
						<tr align="center">
							<td valign="top" align="right">
								<span class="f13blue"><?php echo GetMessage(2)?></span>
							</td>
							<td valign="top" align="left">
								<span class="f13blue"><input style='width:250px' type='password' name='passwd' value='<?php echo $_POST["passwd"]?>'/></span>
							</td>
						</tr>
						<tr align="center">
							<td valign="top" colspan="2">
								<span class="f13blue"><input type='Submit' value='Log in'/></span>
							</td>
						</tr>
						<?php
							if(count($Error) > 0)
							{
								for($i = 0; $i < count($Error); $i++)
								{
									echo "<tr align='center'>";
									echo "	<td valign='top' colspan='2'>";
									echo "		<span class='f13red'><strong>".$Error[$i]."</strong></span>";
									echo "	</td>";
									echo "</tr>";
								}
							}
						?>
						</form>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>
<?php
	if($grs_debugmode == 1)
		include("./inc/grs_debuginfo.php");
?>
