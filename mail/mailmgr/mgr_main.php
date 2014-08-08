<?php
	/*
	Postix Managerinterface for handling virtual domains and users
	Based on the installation of ISPmail tutorial for Debian Lenny
	after the instructions of
	howto: ISPmail tutorial for Debian Lenny
	http://workaround.org/ispmail/lenny
	Author: Dipl.-Inform. Christoph Haas
	--------------------------------------------
	Code written by Peter Gutwein, GRSoft GmbH, peter.gutwein@grsoft.ch, 28.12.2007
	Copyrights: GNU/GPL
	I am happy about your feedback!
	--------------------------------------------
	What this script does is:
	1. MailMaster can delete (recursive), edit (recursive) and create virtual domains in the database
	2. MailMaster can delete, edit and create (with password support) Domain Administrators in the database
	3. DomainMaster can delete, edit and create (with password support) mail user of his own domain in the database
	4. DomainUser can delete, edit and create (with password support) aliases of his own account in the database
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
	session_start();
	$Error = array();
	function fqdn_check($fqdn)
	{
	    return (preg_match("/^([a-zA-Z0-9-]{3,}+\.)+([a-zA-Z]{2,3})$/", $fqdn, $regs));
	}
	function username_check($username)
	{
	    return (preg_match("/^[a-zA-Z0-9-.]{3,30}$/", $username, $regs));
	}
	function password_check($password)
	{
	    return (preg_match("/^[a-zA-Z0-9@$]{8,15}$/",$password, $regs));
	}
	//-------------------------------------
	// Wurde die Sprache verändert?
	if($_POST["newlang"])
	{
		$LocationID = $_POST["locationid"];
		$grs_app_lang = intval($_POST["newlang"]);
		$_SESSION["languageid"] = $grs_app_lang;
	}
	//--------------------------------------
	// User data
	$AuthData = $_SESSION["grs_authentification"];
	if($AuthData)
	{
		if(count($AuthData) > 0)
		{
			$User_Email = stripslashes($AuthData["Email"]);
			$User_Level = $AuthData["Level"];
			$AuthStr    = $User_Email." ".GetMessage(3)." ".$User_Level;
			//--------------------------------------
			if($_POST["aktion"])
			{
				//--------------------------------------
				$LocationID = $_POST["locationid"];
				if(!$LocationID)
					$LocationID = 1;
				if($LocationID == 1 || !$LocationID)
					$inc_actionfile   = "inc/inc_info.php";
				else if($LocationID == 2)
					$inc_actionfile   = "inc/inc_vdomains.php";
				else if($LocationID == 3)
					$inc_actionfile   = "inc/inc_vusers.php";
				else if($LocationID == 5)
					$inc_actionfile   = "inc/inc_duser.php";
				//--------------------------------------
				// Actions
				$Aktion = $_POST["aktion"];
				if($Aktion == "logout")
					$LogoutFlag = 1;
				//--------------------------------------
				// Domain actions
				if($Aktion == "adddomain")
					$valcheck = "checked";
				if($Aktion == "savenewdomain")
				{
					$FQDN  = $_POST["fqdn"];
					$check = $_POST["validation"];
					if($check)
						$valcheck = "checked";
					if(!$FQDN)
					{
						$Error[] = GetMessage(4);
						$Aktion  = "adddomain";
					}
					if($check)
					{
						//-------------------------------
						// Validation
						if(!fqdn_check($FQDN))
						{
							$Error[] = GetMessage(5);
							$Aktion  = "adddomain";
						}
					}
					$query = "Select * from virtual_domains where name='$FQDN'";
					$res   = sql($query, "select");
					if(count($res) > 0)
						$Error[] = "A virtual domain with this name already exists in the database.";
					if(count($Error) == 0)
					{
						$query = "Insert into virtual_domains (name) Values('$FQDN')";
						sql($query, "insert");
					}
				}
				if($Aktion == "editdomain")
					$EditDomainID = $_POST["domainid"];
				if($Aktion == "saveeditdomain")
				{
					$EditDomainID = $_POST["editdomainid"];
					$query        = "Select * from virtual_domains where id=$EditDomainID";
					$res          = sql($query, "select");
					$OldName      = $res[0]["name"];
					$NewName      = $_POST["fqdn"];
					if(!$NewName)
					{
						$Error[] = GetMessage(4);
						$Aktion  = "editdomain";
					}	
					if($NewName == $OldName)
					{
						$Error[] = GetMessage(6);
						$Aktion  = "editdomain";
					}
					if(!fqdn_check($NewName))
					{
						$Error[] = GetMessage(7).$NewName.GetMessage(8);
						$Aktion  = "editdomain";
					}
					
					$query = "Select * from virtual_domains where name='$NewName'";
					$res   = sql($query, "select");
					if(count($res) > 0)
						$Error[] = GetMessage(9);
						
					if(count($Error) == 0)
					{
						$query = "Update virtual_domains set name='$NewName' where id=$EditDomainID";
						sql($query, "update");
						//---------------------------------
						// Change all users
						$query = "Select * from virtual_aliases where domain_id=$EditDomainID";
						$Usrs  = sql($query, "select");
						for($i = 0; $i < count($Usrs); $i++)
						{
							$UserAdrArr = explode("@", $Usrs[$i]["destination"]);
							$NewAdress  = $UserAdrArr[0]."@".$NewName;
							$query = "Update virtual_aliases set destination='$NewAdress' where id=".$Usrs[$i]["id"];
							sql($query, "update");
						}
						$EditDomainID = 0;
					}
					
				}
				if($Aktion == "deletedomain")
				{
					$DomainID = $_POST["domainid"];
					$query = "Delete from virtual_domains where id=$DomainID";
					sql($query, "delete");
					$query = "Delete from virtual_users where domain_id=$DomainID";
					sql($query, "delete");
					$query = "Delete from virtual_aliases where domain_id=$DomainID";
					sql($query, "delete");
					$query = "Delete from domain_admins where domain_id=$DomainID";
					sql($query, "delete");
				}
				//-------------------------------------------
				// Users
				if($Aktion == "selectdomain")
					$DomainID = $_POST["domainselect"];
				if($Aktion == "selectmasters")
					$DomainID = $_POST["domainselect"];
				if($Aktion == "savemasters")
				{
					$DomainID = $_POST["domainselect"];
					$query = "Delete from domain_admins where domain_id=$DomainID";
					sql($query, "delete");
					$query    = "Select * from virtual_users where domain_id=$DomainID";
					$res      = sql($query, "select");
					for($i = 0; $i < count($res); $i++)
					{
						if($_POST["userid_".$res[$i]["id"]])
						{
							$query = "Insert into domain_admins (user_id, domain_id) Values(".$res[$i]["id"].",$DomainID)";
							sql($query, "insert");
						}
					}
				}
				if($Aktion == "deleteuser")
				{
					$DomainID = $_POST["domainid"];
					$UserID   = $_POST["userid"];
					$DelName  = $_POST["userdelname"];
					$Domain   = GetUserDomainbyID($UserID);
					$DomainID = $Domain["id"];
					$UserDest = $DelName."@".$DomainID["name"];
					$query    = "Delete from virtual_aliases where domain_id=$DomainID AND (source='$DelName' OR destination='$UserDest')";
					sql($query, "delete");
					$query    = "Delete from virtual_users where id=$UserID";
					sql($query, "delete");
					$query = "Delete from domain_admins where user_id=$UserID";
					sql($query, "delete");
				}
				if($Aktion == "edituser")
				{
					$DomainID     = $_POST["domainid"];
					$EditDUserID  = $_POST["edituserid"];
				}
				if($Aktion == "edituseraccount")
				{
					$DomainID    = $_POST["domainid"];
					$EditUserID  = $_POST["userselect"];
				}
				if($Aktion == "saveeditaccount")
				{
					$DomainID   = $_POST["domainid"];
					$EditUserID = $_POST["edituserid"];
					$Newsource  = $_POST["source"];
					// Syntax checken
					if(!$Newsource)
						$Error[] = GetMessage(10);
					else if(!username_check($Newsource))
						$Error[] = GetMessage(11).$Newsource.GetMessage(12);
					if(count($Error) == 0)
					{	
						$Password = $_POST["password"];
						if($Password)
						{
							if(!password_check($Password))
								$Error[] = GetMessage(13).$Password.GetMessage(14);
						}
						$passwordchanged = 1;
					}
					if(count($Error) == 0)
					{
						$query = "Select * from virtual_users where user='$Newsource' AND domain_id=$DomainID";
						$res   = sql($query, "select");
						if(count($res) > 0 && !$passwordchanged)
							$Error[] = GetMessage(15);
					}
					if(count($Error) == 0)
					{	
						$query   = "Select * from virtual_users where id=$EditUserID";
						$res     = sql($query, "select");
						$oldname = $res[0]["user"];
						
						$Userdata = GetUserdatabyID($EditUserID);
						$aid      = $Userdata["id"];
						$query = "Select * from virtual_domains where id=$DomainID";
						$inf   = sql($query, "select");
						$DomainName = $inf[0]["name"];
						$Newdestination = $Newsource."@".$DomainName;
						if($aid)
						{
							$query   = "Update virtual_aliases set source='$Newsource', destination='$Newdestination' where id=$aid";
							sql($query, "update");
						}
						$query   = "Update virtual_aliases set source='$Newsource' where source='$oldname' and domain_id=$DomainID";
						sql($query, "update");

						if($Password)
							$query = "Update virtual_users set user='$Newsource', password='".md5($Password)."' where id=$EditUserID";
						else
							$query = "Update virtual_users set user='$Newsource' where id=$EditUserID";
						sql($query, "update");
						$EditUserAccountFlag = false;
						$CreatePasswordFlag  = false;
					}
					else
					{
						$EditUserAccountFlag = 1;
						$Aktion == "editaccount";
					}
				}
				if($Aktion == "editaccount")
				{
					$DomainID   = $_POST["domainid"];
					$EditUserAccountFlag = 1;
					$EditUserID =  $_POST["edituserid"];
				}
				if($Aktion == "saverealalias")
				{
					$DomainID   = $_POST["domainid"];
					$AliasID    = $_POST["editaliasid"];
					$EditUserID = $_POST["edituserid"];
					$NewAlias   = $_POST["alisource"];
					if(!$NewAlias)
					{
						if($User_Level == "DomainUser")
							$Error[] = GetMessage(90);
						else
							$NewAlias = "";
					}
					else
					{
						if($User_Level == "DomainUser")
						{
							$query = "Select * from virtual_aliases where domain_id=$DomainID AND source='$NewAlias';";
							if(count(sql($query, "select")) > 0)
								$Error[] = GetMessage(89);
						}
					}
					if(count($Error) == 0)
					{
						$query = "Update virtual_aliases Set source='$NewAlias' where id=$AliasID;";
						sql($query, "update");
					}
					else
						$Aktion = "editrealalias";
				}
				if($Aktion == "editrealalias")
				{
					$DomainID         = $_POST["domainid"];
					$EditUserID       = $_POST["edituserid"];
					$EditRealAliasAccount = $_POST["editaliasid"];
				}
				if($Aktion == "deleterealalias")
				{
					$DomainID   = $_POST["domainid"];
					$EditUserID = $_POST["edituserid"];
					$AliasID    = $_POST["editaliasid"];
					$query = "Delete from virtual_aliases where id=$AliasID";
					sql($query, "delete");
				}
				if($Aktion == "addrealalias")
				{
					$DomainID   = $_POST["domainid"];
					$EditUserID = $_POST["edituserid"];
				}
				if($Aktion == "savenewrealalias")
				{
					$DomainID   = $_POST["domainid"];
					$EditUserID = $_POST["edituserid"];
					$NewAlias   = $_POST["alisource"];
					if(!$NewAlias)
					{
						if($User_Level == "DomainUser")
							$Error[] = GetMessage(90);
						else
							$NewAlias = "";
					}
					else
					{
						if($User_Level == "DomainUser")
						{
							$query = "Select * from virtual_aliases where domain_id=$DomainID AND source='$NewAlias';";
							if(count(sql($query, "select")) > 0)
								$Error[] = GetMessage(89);
						}
					}
					if(count($Error) == 0)
					{
						$Username   = GetUserNamebyID($EditUserID);
						$Domain     = GetDomainbyID($DomainID);
						$Dom 		= $Domain["name"];
						$Destination = $Username."@".$Dom;
						//$Destination = $Username;
						$query = "Insert into virtual_aliases (domain_id, source, destination) Values($DomainID, '$NewAlias', '$Destination');";
						sql($query, "insert");
						$Aktion == "";
					}
					else
						$Aktion = "addrealalias";
				}
				if($Aktion == "savealias")
				{
					$DomainID         = $_POST["domainid"];
					$EditUserID       = $_POST["edituserid"];
					$EditAliasAccount = $_POST["editaliasid"];
					$newdestination   = $_POST["newdestination"];
					if(!$newdestination)
						$Error[] = GetMessage(61);
					else
					{
						$Testarr = explode("@", $newdestination);
						if(count($Testarr) != 2)
							$Error[] = GetMessage(63);
						else
						{
							if(!fqdn_check($Testarr[1]))
								$Error[] = GetMessage(64);
							else
							{
								if(!username_check($Testarr[0]))
									$Error[] = GetMessage(65);
							}
						}
					}
					if(count($Error) == 0)
					{
						$query = "Update virtual_aliases SET destination='$newdestination' where id=$EditAliasAccount";
						sql($query, "update");
						$EditAliasAccount = 0;
					}
				}
				if($Aktion == "editalias")
				{
					$DomainID         = $_POST["domainid"];
					$EditUserID       = $_POST["edituserid"];
					$EditAliasAccount = $_POST["editaliasid"];
				}
				if($Aktion == "deletealias")
				{
					$DomainID   = $_POST["domainid"];
					$EditUserID = $_POST["edituserid"];
					$AliasID    = $_POST["editaliasid"];
					$query = "Delete from virtual_aliases where id=$AliasID";
					sql($query, "delete");
				}
				if($Aktion == "addalias")
				{
					$DomainID   = $_POST["domainid"];
					$EditUserID = $_POST["edituserid"];
				}
				if($Aktion == "savenewalias")
				{
					$DomainID         = $_POST["domainid"];
					$EditUserID       = $_POST["edituserid"];
					$newdestination   = $_POST["newdestination"];
					if(!$newdestination)
						$Error[] = GetMessage(61);
					else
					{
						$Testarr = explode("@", $newdestination);
						if(count($Testarr) != 2)
							$Error[] = GetMessage(63);
						else
						{
							if(!fqdn_check($Testarr[1]))
								$Error[] = GetMessage(64);
							else
							{
								if(!username_check($Testarr[0]))
									$Error[] = GetMessage(65);
							}
						}
					}
					if(count($Error) == 0)
					{
						$source   = GetUserNamebyID($EditUserID);
						$query = "Insert into virtual_aliases (domain_id, source, destination) Values($DomainID, '$source', '$newdestination')";
						sql($query, "insert");
					}
					else
						$Aktion = "addalias";
				}
				if($Aktion == "setpasswordflag2")
				{
					$DomainID      = $_POST["domainid"];
					$EditUserID    = $_POST["edituserid"];
					$Newusersource = $_POST["source"];
					$CreatePasswordFlag = 1;
					$EditUserAccountFlag = 1;
					$Aktion == "editaccount";
				}
				if($Aktion == "setpasswordflag")
				{
					$DomainID     = $_POST["domainid"];
					$EditDUserID  = $_POST["edituserid"];
					$CreatePasswordFlag = 1;
				}
				if($Aktion == "adduser")
				{
					$valcheck = "checked";
					$DomainID = $_POST["domainid"];
				}
				if($Aktion == "saveedituser")
				{
					$EditDUserID = $_POST["edituserid"];
					$Domain      = GetUserDomainbyID($EditDUserID);
					$DomainID    = $Domain["id"];
					$DomainName  = $Domain["name"];
					$UserName    = $_POST["source"];
					$Password    = $_POST["password"];
					
					$UserEmail = $UserName;
					
					if(!$UserName)
						$Error[] = GetMessage(10);
					if(!username_check($UserName))
						$Error[] = GetMessage(11).$NewName.GetMessage(12);
					if($Password)
					{
						if(!password_check($Password))
							$Error[] = GetMessage(13).$Password.GetMessage(14);
					}
					if(!$Password)
					{
						//$query = "Select * from virtual_users where user='$UserName' AND domain_id=$DomainID";
						$query = "Select * from virtual_users where user='$UserEmail' AND domain_id=$DomainID";
						$res   = sql($query, "select");
						if(count($res) > 0)
							$Error[] = GetMessage(15);
					}
						
					if(count($Error) == 0)
					{
						$query   = "Select * from virtual_users where id=$EditDUserID";
						$res     = sql($query, "select");
						$oldname = $res[0]["user"];
						//$Newdestination = $UserName."@".$DomainName;
						$Newdestination = $UserEmail;
						
						$Userdata = GetUserdatabyID($EditDUserID);
						$aid      = $Userdata["id"];
						if($aid)
						{
							$query   = "Update virtual_aliases set source='$UserName', destination='$Newdestination' where id=$EditDUserID";
							sql($query, "update");
						}
						$query   = "Update virtual_aliases set source='$UserName' where source='$oldname' and domain_id=$DomainID";
						sql($query, "update");
						if($Password)
							$query = "Update virtual_users set user='$UserEmail', password='".md5($Password)."' where id=$EditDUserID";
						else
							$query = "Update virtual_users set user='$UserEmail' where id=$EditDUserID";
						sql($query, "update");
						$EditDUserID  = 0;
					}
					else
						$Aktion  = "edituser";	
				}
				if($Aktion == "savenewuser")
				{
					$DomainID = $_POST["domainid"];
					$Domain   = GetDomainbyID($DomainID);
					$UserName = $_POST["username"];
					$Password = $_POST["password"];
					$DomainName = $Domain["name"];
					$UserEmail = $UserName;
					if(!$UserName)
					{
						$Error[] = GetMessage(16);
						$Aktion  = "adduser";
					}
					if(!$Password)
					{
						$Error[] = GetMessage(17);
						$Aktion  = "adduser";
					}
					if(!username_check($UserName))
					{
						$Error[] = GetMessage(11).$NewName.GetMessage(12);
						$Aktion  = "adduser";
					}
					if(!password_check($Password))
					{
						$Error[] = GetMessage(13).$Password.GetMessage(14);
						$Aktion  = "adduser";
					}
					//$query = "Select * from virtual_users where user='$UserName' AND domain_id=$DomainID";
					$query = "Select * from virtual_users where user='$UserName' AND domain_id=$DomainID";
					$res   = sql($query, "select");
					if(count($res) > 0)
						$Error[] = GetMessage(15);
					if(count($Error) == 0)
					{
						$query = "Insert into virtual_users (domain_id, user, password) Values($DomainID, '$UserEmail', '".md5($Password)."' )";
						sql($query, "insert");
					}
					else
						$Aktion = "adduser";	
				}
			}
			else
				$LogoutFlag = 1;
		}
		else
			$LogoutFlag = 1;
	}
	else
		$LogoutFlag = 1;
	if($LogoutFlag == 1)
		$_SESSION["grs_authentification"] = array();
	
?>
<html>
	<head>
		<META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">
		<title>Mail-Manager</title>
		<link rel="stylesheet" type="text/css" href="css/frm_styles.css">
		<script language="JavaScript">
			function ChangeLanguage(lid)
			{
				document.forms.langswitch.newlang.value = lid;
				document.forms.langswitch.submit();
			}
			function NavigateTo(NavID)
			{
				document.forms.navigateto.locationid.value = NavID;
				if(NavID == 4)
					document.forms.navigateto.aktion.value = "logout";
				else
					document.forms.navigateto.aktion.value = "navigate";
				document.forms.navigateto.submit();
			}
			function AddDomain()
			{
				document.forms.domains.aktion.value = "adddomain";
				document.forms.domains.submit();
			}
			
			function AddUser()
			{
				document.forms.domainuser.aktion.value = "adduser";
				document.forms.domainuser.submit();
			}
			function SaveNewDomain()
			{
				document.forms.domains.aktion.value = "savenewdomain";
				document.forms.domains.submit();
			}			
			function SaveNewUser()
			{
				document.forms.domainuser.aktion.value = "savenewuser";
				document.forms.domainuser.submit();
			}
			function EditDomain(Did, Domainname)
			{
				document.forms.domains.aktion.value = "editdomain";
				document.forms.domains.domainid.value = Did;
				document.forms.domains.submit();
			}
			
			function EditUser(Aid, Source)
			{
				document.forms.domainuser.aktion.value = "edituser";
				document.forms.domainuser.edituserid.value = Aid;
				document.forms.domainuser.userdelname.value = 'Source';
				document.forms.domainuser.submit();
			}
			function SaveEditUser(Aid, Source)
			{
				document.forms.domainuser.aktion.value = "saveedituser";
				document.forms.domainuser.edituserid.value = Aid;
				document.forms.domainuser.userdelname.value = 'Source';
				document.forms.domainuser.submit();
			}
			
			function DeleteDomain(Did, Domainname)
			{
				var str = "<?php echo GetMessage(18)?>" + Domainname;
				str += "<?php echo GetMessage(19)?>";
				if(confirm(str))
				{
					document.forms.domains.aktion.value = "deletedomain";
					document.forms.domains.domainid.value = Did;
					document.forms.domains.submit();
				}
			}
			function DeleteUser(Aid, Username)
			{
				if(confirm("<?php echo GetMessage(20)?>" + Username + "?"))
				{
					document.forms.domainuser.aktion.value = "deleteuser";
					document.forms.domainuser.userid.value = Aid;
					document.forms.domainuser.userdelname.value = 'Username';
					document.forms.domainuser.submit();
				}
			}
			function SetPasswordFlag()
			{
				document.forms.domainuser.aktion.value = "setpasswordflag";
				document.forms.domainuser.submit();
			}
			function SaveEditDomain(Did, Domainname)
			{
				if(confirm("<?php echo GetMessage(21)?> " + Domainname + "?\n<?php echo GetMessage(22)?>"))
				{
					document.forms.domains.aktion.value = "saveeditdomain";
					document.forms.domains.domainid.value = Did;
					document.forms.domains.submit();
				}
			}
			function SelectDomain()
			{
				document.forms.domainuser.aktion.value = "selectdomain";
				document.forms.domainuser.submit();
			}
			function DomainAdmins()
			{
				document.forms.domainuser.aktion.value = "selectmasters";
				document.forms.domainuser.submit();
			}
			function SaveDomainMasters()
			{
				document.forms.domainuser.aktion.value = "savemasters";
				document.forms.domainuser.submit();
			}
			function SelectUserDomain()
			{
				document.forms.edituser.aktion.value = "selectdomain";
				document.forms.edituser.submit();
			}
			function SelectUser()
			{
				document.forms.edituser.aktion.value = "edituseraccount";
				document.forms.edituser.submit();
			}
			function EditUserAccount(EditUserID)
			{
				document.forms.edituser.aktion.value = "editaccount";
				document.forms.edituser.edituserid.value = EditUserID;
				document.forms.edituser.submit();
			}
			function SaveEditUserAccount(EditUserID)
			{
				document.forms.edituser.aktion.value = "saveeditaccount";
				document.forms.edituser.edituserid.value = EditUserID;
				document.forms.edituser.submit();
			}
			function SaveEditUserAlias(AliasID)
			{
				document.forms.edituser.aktion.value = "savealias";
				document.forms.edituser.editaliasid.value = AliasID;
				document.forms.edituser.submit();
			}
			function EditUserAlias(AliasID)
			{
				document.forms.edituser.aktion.value = "editalias";
				document.forms.edituser.editaliasid.value = AliasID;
				document.forms.edituser.submit();
			}
			function AddAlias()
			{
				document.forms.edituser.aktion.value = "addalias";
				document.forms.edituser.submit();
			}
			function SaveNewAlias()
			{
				document.forms.edituser.aktion.value = "savenewalias";
				document.forms.edituser.submit();
			}
			function DeleteUserAlias(AliasID)
			{
				if(confirm("<?php echo GetMessage(88)?>"))
				{
					document.forms.edituser.aktion.value = "deletealias";
					document.forms.edituser.editaliasid.value = AliasID;
					document.forms.edituser.submit();
				}
			}
			function SetPasswordFlag2()
			{
				document.forms.edituser.aktion.value = "setpasswordflag2";
				document.forms.edituser.submit();
			}
			function SaveEditUserRealAlias(AliasID)
			{
				document.forms.edituser.aktion.value = "saverealalias";
				document.forms.edituser.editaliasid.value = AliasID;
				document.forms.edituser.submit();
			}
			function EditUserRealAlias(AliasID)
			{
				document.forms.edituser.aktion.value = "editrealalias";
				document.forms.edituser.editaliasid.value = AliasID;
				document.forms.edituser.submit();
			}
			function AddRealAlias()
			{
				document.forms.edituser.aktion.value = "addrealalias";
				document.forms.edituser.submit();
			}
			function SaveNewRealAlias()
			{
				document.forms.edituser.aktion.value = "savenewrealalias";
				document.forms.edituser.submit();
			}
			function DeleteUserRealAlias(AliasID)
			{
				if(confirm("<?php echo GetMessage(66)?>"))
				{
					document.forms.edituser.aktion.value = "deleterealalias";
					document.forms.edituser.editaliasid.value = AliasID;
					document.forms.edituser.submit();
				}
			}
		</script>
	</head>
	<body bgColor='#ffffff' bottomMargin=0 leftMargin='0' topMargin='0' rightMargin='0' marginwidth='0' marginheight='0'>
		<form name="langswitch" id="langswitch" action="mgr_main.php?PHPSESSID=<?php echo session_id()?>" method="post">
			<input type="hidden" name="newlang" id="newlang" value=""/>
			<input type="hidden" name="aktion" value="<?php echo $Aktion?>"/>
			<input type="hidden" name="locationid" value="<?php echo $LocationID?>"/>
		</form>
		<form name='gologin' action='login.php' method='post'>
		</form>
		<form name='navigateto' action='mgr_main.php?PHPSESSID=<?php echo session_id()?>' method='post'>
			<input type="hidden" name="aktion" value=""/>
			<input type="hidden" name="locationid" value="<?php echo $LocationID?>"/>
		</form>
		<?php
			if($LogoutFlag == 1)
			{
				echo "<script language='JavaScript'>";
				echo "	document.forms.gologin.submit();";
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
				<td valign="top">
					<table cellspacing="5" cellpadding="5" border="0" width="100%">
						<tr>
							<td valign="top" align="right" bgcolor="#bbbbbb" colspan="2">
								<span class="f10blue"><?php echo $AuthStr?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php include("inc/inc_languages.php")?>
							</td>
						</tr>
						<tr>
							<td valign="top" bgcolor="#ffffff" width="20%">
								<?php include("inc/inc_standard_nav.php")?>
							</td>
							<td valign="top" width="80%">
								<?php include($inc_actionfile)?>
							</td>
						</tr>
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
