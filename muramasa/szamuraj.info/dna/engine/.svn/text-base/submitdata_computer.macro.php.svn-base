<?
	if($FUNC=="CreateComputer") $q="insert into computers set";
	else $q="update computers set";
	$q.=" IPDomainID=".$ipdomainid;
	$q.=",IPEnd='".addslashes($ipend)."'";
	$q.=",NameDomainID=".$namedomainid;
	$q.=",NameBegin='".addslashes($namebegin)."'";
	$q.=",HWAddr='".$hwaddr."'";
	$q.=",RootID=".$rootid;
	$q.=",Building='".addslashes($building)."'";
	$q.=",Room='".addslashes($room)."'";
	if($FUNC=="CreateComputer") $q.=",CreateD=".TIME;
	$q.=",ModifyD=".TIME;
	if($FUNC=="CreateComputer") $q.=",ValidUntilD=".$validuntild;
	$q.=",AccessClass=".$accessclass;
	$q.=",IsOfficial=".$isofficial;
	if($FUNC=="ModifyComputer") $q.=" where ID=".$computerid;
	$q.=";";
	db_q($q,$sock,$FUNC.": doing");
	if($FUNC=="CreateComputer"){
		$q="select ID from computers order by ID desc limit 1;";
		$res=db_q($q,$sock,$FUNC.": guessing inserted computer's ID");
		$row=db_fetch_object($res);
		db_free_result($res);
		$computerid=$row->ID;
		if(isset($row)) unset($row);
//		$computerid=db_insert_id($sock); // Not working ??? :-(
	}
	$computer=ReadComputer($sock,$computerid);
	dblog_Append($sock,DBLOG_WEIGHT_NORMAL,$user,$FUNC,"ID=".$computer->ID.",Name='".addslashes($computer->Name)."',IP='".$computer->IP."'");
?>
