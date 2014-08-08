<?
	if($func=="trynewuser") $q="insert into users set";
	else $q="update users set";
	$q.=" Nick='".addslashes($nick)."'";
	$q.=",Email='".addslashes($email)."'";
	$q.=",RealName='".addslashes($realname)."'";
	$q.=",Rights='".addslashes($rights)."'";
	if($pass1!="") $q.=",Password=old_password('".addslashes($pass1)."')";
	if($func!="trynewuser") $q.=" where ID=".$luser->ID;
	$q.=";";
	db_q($q,$sock,$FUNC.": updating/inserting");
//TODO	dblog_Append($sock,DBLOG_WEIGHT_WARNING,$user,"LOGIN-DENIED","SessionID=".$session->ID.",UserID=".$luser->ID.",UserNick='".addslashes($luser->Nick)."'");
?>
