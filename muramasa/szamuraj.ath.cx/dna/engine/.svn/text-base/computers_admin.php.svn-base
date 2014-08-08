<?
	require_once("engine/computers_common.php");
	require_once("engine/cnames_common.php");
	require_once("engine/roots_admin.php");
//----------------------------------------------------------
	function CreateComputer($sock,$user,$ipdomainid,$ipend,$namedomainid,$namebegin,$hwaddr,$rootid,$building,$room,$validuntild,$accessclass,$isofficial){
		$FUNC="CreateComputer";
		require("engine/submitdata_computer.macro.php");
		return($computer);
	}
//----------------------------------------------------------
	function ModifyComputer($sock,$user,$computerid,$ipdomainid,$ipend,$namedomainid,$namebegin,$hwaddr,$rootid,$building,$room,$accessclass,$isofficial){
		$FUNC="ModifyComputer";
		require("engine/submitdata_computer.macro.php");
		return($computer);
	}
//----------------------------------------------------------
	function DeleteComputer($sock,$user,$computer){
		$FUNC="DeleteComputer";
		$q="delete from computers where ID=".$computer->ID.";";
		db_q($q,$sock,$FUNC.": removing");
		dblog_Append($sock,DBLOG_WEIGHT_NORMAL,$user,$FUNC,"ID=".$computer->ID.",Name='".addslashes($computer->Name)."',IP='".$computer->IP."'");
	}
//----------------------------------------------------------
	function ReadComputersByHWAddr($sock,$hwaddr){
		$FUNC="ReadComputersByHWAddr";
		$q="select a.*,concat(b.IPBegin,'.',a.IPEnd) as IP,concat(a.NameBegin,'.',c.NameEnd) as Name";
		$q.=",d.RealName,d.Building as RootBuilding,d.Room as RootRoom,d.Email,(a.IPEnd+0) as IPEndNumeric,d.PersonalID";
		$q.=" from computers a left join domains b on a.IPDomainID=b.ID left join domains c on a.NameDomainID=c.ID left join roots d on a.RootID=d.ID";
		$q.=" where HWAddr='".$hwaddr."';";
		$res=db_q($q,$sock,$FUNC.": selecting");
		return(ResToDim_Free($res));
	}
//----------------------------------------------------------
	function ReadComputersByIP($sock,$domainid,$ipend){
		$FUNC="ReadComputersByIP";
		$q="select a.*,concat(b.IPBegin,'.',a.IPEnd) as IP,concat(a.NameBegin,'.',c.NameEnd) as Name";
		$q.=",d.RealName,d.Building as RootBuilding,d.Room as RootRoom,d.Email,(a.IPEnd+0) as IPEndNumeric,d.PersonalID";
		$q.=" from computers a left join domains b on a.IPDomainID=b.ID left join domains c on a.NameDomainID=c.ID left join roots d on a.RootID=d.ID";
		$q.=" where IPDomainID=".$domainid." and IPEnd='".addslashes($ipend)."';";
		$res=db_q($q,$sock,$FUNC.": selecting");
		return(ResToDim_Free($res));
	}
//----------------------------------------------------------
	function ReadComputersByValidityState($sock,$validitystate){
		$FUNC="ReadComputersByValidityState";
		$q="select a.*,concat(b.IPBegin,'.',a.IPEnd) as IP,concat(a.NameBegin,'.',c.NameEnd) as Name";
		$q.=",d.RealName,d.Building as RootBuilding,d.Room as RootRoom,d.Email,(a.IPEnd+0) as IPEndNumeric,d.PersonalID";
		$q.=" from computers a left join domains b on a.IPDomainID=b.ID left join domains c on a.NameDomainID=c.ID left join roots d on a.RootID=d.ID";
		$q.=" where ".q_ValidityState($validitystate,TIME,"a").";";
		$res=db_q($q,$sock,$FUNC.": selecting");
		return(ResToDim_Free($res));
	}
//----------------------------------------------------------
	function DeleteUnpayedComputers($sock,$user){
		$FUNC="DeleteUnpayedComputers";
		dblog_Append($sock,DBLOG_WEIGHT_NORMAL,$user,$FUNC,"");
		$computers=ReadComputersByValidityState($sock,VALIDITYSTATE_INVALID);
		for($i=0;$i<count($computers);$i++){
			DeleteComputer($sock,$user,$computers[$i]);
			AdjustRootComputerCount($sock,$computers[$i]->RootID,-1);
			$root=ReadRoot($sock,$computers[$i]->RootID);
			if(is_object($root))
			{
				if($root->ComputerCount==0)
					DeleteRoot($sock,$user,$root);
			}
		}
	}
//----------------------------------------------------------
	function SetComputerValidUntilD($sock,$user,$computer,$validuntild){
		$FUNC="SetComputerValidUntilD";
		$q="update computers set ValidUntilD=".$validuntild." where ID=".$computer->ID.";";
		db_q($q,$sock,$FUNC.": updating ValidUntilD");
		dblog_Append($sock,DBLOG_WEIGHT_NORMAL,$user,$FUNC,"ID=".$computer->ID.",Name='".addslashes($computer->Name)."',ValidUntilD='".StampToDateTime($validuntild)."' (".$validuntild.")");
	}
//----------------------------------------------------------
	function BanComputer($sock,$user,$computer,$banneduntild,$comment){
		$FUNC="BanComputer";
		$q="update computers set BannedUntilD=".$banneduntild." where ID=".$computer->ID.";";
		db_q($q,$sock,$FUNC.": updating");
		$q="insert into banlog set";
		$q.=" CreateD=".TIME;
		$q.=",EventType=".BANLOG_EVENTTYPE_BAN;
		$q.=",UserID=".$user->ID;
		$q.=",UserNick='".addslashes($user->Nick)."'";
		$q.=",UserName='".addslashes($user->RealName)."'";
		$q.=",BanEndD=".$banneduntild;
		$q.=",ComputerID=".$computer->ID;
		$q.=",ComputerName='".addslashes($computer->Name)."'";
		$q.=",ComputerIP='".addslashes($computer->IP)."'";
		$q.=",ComputerRealName='".addslashes($computer->RealName)."'";
		$q.=",Comment='".addslashes($comment)."'";
		$q.=";";
		db_q($q,$sock,$FUNC.": creating log entry");
		$id=db_insert_id($sock);
		dblog_Append($sock,DBLOG_WEIGHT_NORMAL,$user,$FUNC,"ID=".$computer->ID.",Name='".addslashes($computer->Name)."',IP='".$computer->IP."'");
		$entry=db_RecordByID($sock,"banlog",$id);
		return($entry);
	}
//----------------------------------------------------------
	function LimitComputer($sock,$user,$computer,$limiteduntild,$comment){
		$FUNC="LimitComputer";
		$q="update computers set LimitedUntilD=".$limiteduntild." where ID=".$computer->ID.";";
		db_q($q,$sock,$FUNC.": updating");
		$q="insert into banlog set";
		$q.=" CreateD=".TIME;
		$q.=",EventType=".BANLOG_EVENTTYPE_LIMIT;
		$q.=",UserID=".$user->ID;
		$q.=",UserNick='".addslashes($user->Nick)."'";
		$q.=",UserName='".addslashes($user->RealName)."'";
		$q.=",BanEndD=".$limiteduntild;
		$q.=",ComputerID=".$computer->ID;
		$q.=",ComputerName='".addslashes($computer->Name)."'";
		$q.=",ComputerIP='".addslashes($computer->IP)."'";
		$q.=",ComputerRealName='".addslashes($computer->RealName)."'";
		$q.=",Comment='".addslashes($comment)."'";
		$q.=";";
		db_q($q,$sock,$FUNC.": creating log entry");
		$id=db_insert_id($sock);
		dblog_Append($sock,DBLOG_WEIGHT_NORMAL,$user,$FUNC,"ID=".$computer->ID.",Name='".addslashes($computer->Name)."',IP='".$computer->IP."'");
		$entry=db_RecordByID($sock,"banlog",$id);
		return($entry);
	}
//----------------------------------------------------------
	function UnbanComputer($sock,$user,$computer,$comment){
		$FUNC="UnbanComputer";
		$q="update computers set BannedUntilD=0 where ID=".$computer->ID.";";
		db_q($q,$sock,$FUNC.": updating");
		$q="insert into banlog set";
		$q.=" CreateD=".TIME;
		$q.=",EventType=".BANLOG_EVENTTYPE_UNBAN;
		$q.=",UserID=".$user->ID;
		$q.=",UserNick='".addslashes($user->Nick)."'";
		$q.=",UserName='".addslashes($user->RealName)."'";
		$q.=",BanEndD=".TIME;
		$q.=",ComputerID=".$computer->ID;
		$q.=",ComputerName='".addslashes($computer->Name)."'";
		$q.=",ComputerIP='".addslashes($computer->IP)."'";
		$q.=",ComputerRealName='".addslashes($computer->RealName)."'";
		$q.=",Comment='".addslashes($comment)."'";
		$q.=";";
		db_q($q,$sock,$FUNC.": creating log entry");
		$id=db_insert_id($sock);
		$entry=db_RecordByID($sock,"banlog",$id);
		dblog_Append($sock,DBLOG_WEIGHT_NORMAL,$user,$FUNC,"ID=".$computer->ID.",Name='".addslashes($computer->Name)."',IP='".$computer->IP."'");
		return($entry);
	}
//----------------------------------------------------------
	function UnlimitComputer($sock,$user,$computer,$comment){
		$FUNC="UnlimitComputer";
		$q="update computers set LimitedUntilD=0 where ID=".$computer->ID.";";
		db_q($q,$sock,$FUNC.": updating");
		$q="insert into banlog set";
		$q.=" CreateD=".TIME;
		$q.=",EventType=".BANLOG_EVENTTYPE_UNLIMIT;
		$q.=",UserID=".$user->ID;
		$q.=",UserNick='".addslashes($user->Nick)."'";
		$q.=",UserName='".addslashes($user->RealName)."'";
		$q.=",BanEndD=".TIME;
		$q.=",ComputerID=".$computer->ID;
		$q.=",ComputerName='".addslashes($computer->Name)."'";
		$q.=",ComputerIP='".addslashes($computer->IP)."'";
		$q.=",ComputerRealName='".addslashes($computer->RealName)."'";
		$q.=",Comment='".addslashes($comment)."'";
		$q.=";";
		db_q($q,$sock,$FUNC.": creating log entry");
		$id=db_insert_id($sock);
		$entry=db_RecordByID($sock,"banlog",$id);
		dblog_Append($sock,DBLOG_WEIGHT_NORMAL,$user,$FUNC,"ID=".$computer->ID.",Name='".addslashes($computer->Name)."',IP='".$computer->IP."'");
		return($entry);
	}
//----------------------------------------------------------
	function GuessFreeIP3($sock,$domainid){
		$FUNC="GuessFreeIP2";
		$ret=array();
		$q="select distinct IPEnd from computers where IPDomainID=".$domainid." order by (IPEnd + 0);";
		$res=db_q($q,$sock,$FUNC.": selecting used IP addresses.");
		for($ip=1,$row=db_fetch_object($res);$ip<255 || $row!==FALSE;){
			if($ip==255)
				break;
			if($row===FALSE || $ip<$row->IPEnd)
			{
				$ret[]=$ip;
				$ip++;
				continue;
			}
			if($ip>$row->IPEnd)
			{
				$row=db_fetch_object($res);
				continue;
			}
			$ip++;
			$row=db_fetch_object($res);
		}
		db_free_result($res);
		return $ret;
	}
//----------------------------------------------------------
	function ReadMasterIPs($sock,$ipdomainid){
		$FUNC="ReadMasterIps";
		$q="select * from masterips";
		$q.="where IPDomainID=".$namedomainid.";";
		$res=db_q($q,$sock,$FUNC.": selecting");
		return(ResToDim_Free($res));
	}
//----------------------------------------------------------
	function ReadMasterIPByIP($sock,$ipdomainid,$ipend){
		$FUNC="ReadMasterIPByIp";
		$q="select * from masternames";
		$q.="where IPEnd='".addslashes($ipend)."'";
		$q.=" and IPDomainID=".$ipdomainid.";";
		$res=db_q($q,$sock,$FUNC.": searching");
		if(db_num_rows($res)>=1) $masterip=db_fetch_object($res);
		else $masterip="";
		db_free_result($res);
		return(ResToDim_Free($masterip));
	}
//----------------------------------------------------------
	function SendValidityWarning($sock,$computer,$limit,$ttl)
	{
		$email=new stdClass;
		$email->To=$computer->Email;
		$email->Subject=$computer->NameBegin.": kevesebb mint ".SecstoTime($limit,"nap","óra","perc","másodperc","semennyi")." maradt";
		$email->ReplyTo="Szalai Imre <simre@csoma.elte.hu>";
		$email->isMultipartAlternative=1;
		
		$email->parts[1]=new stdClass;
		$email->parts[1]->MimeType="text/html; charset=".CFG_DEFAULT_CHARSET;
		ob_start();
		require("engine/warnemail_template.php");
		$email->parts[1]->Text=ob_get_contents();
		ob_end_clean();
		
		$email->parts[0]=new stdClass;
		$email->parts[0]->MimeType="text/plain; charset=".CFG_DEFAULT_CHARSET;
		$email->parts[0]->Text=HTMLToText($email->parts[1]->Text,"UTF-8");
		
		$email->To=$computer->RealName." <".$computer->Email.">";
		SendPlainEmail($email);
		
		if(defined("EMAIL_SIMULATE_ONLY") && strtolower(EMAIL_SIMULATE_ONLY)=="true")
			return;
		$q="update computers set LastValidityWarningD=".TIME." where id=".$computer->ID.";";
		db_q($q,$sock,__FUNC__.": Settting last validity warning date for computer");
	}
?>
