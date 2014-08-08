<?
	define("DOMAINTYPE_FORWARD",1);
	define("DOMAINTYPE_REVERSE",2);
//----------------------------------------------------------
	function CountCnamesForDomain($sock,$domainid)
	{
		$q="select 1 from cnames where cname.NameDomainID1=".$domainid.";";
		$res=db_q($q,$sock,__FUNCTION__.": counting");
		$ret=db_num_rows($res);
		db_free_result($res);
		return $ret;
	}
//----------------------------------------------------------
	function CountComputersForDomain($sock,$domainid)
	{
		$q="select 1 from computers where computer.NameDomainID=".$domainid." or computer.IPDomainID=".$domainid.";";
		$res=db_q($q,$sock,__FUNCTION__.": counting");
		$ret=db_num_rows($res);
		db_free_result($res);
		return $ret;
	}
//----------------------------------------------------------
	function ReadDomain($sock,$domainid,$add_counters=false){
		$FUNC="ReadDomain";
		if(!$add_counters)
			return db_RecordByID($sock,"domains",$domainid);
		$q="select domains.*";
		$q.="  ,( select count(*)";
		$q.="    from computers";
		$q.="    where computers.NameDomainID=domains.ID";
		$q.="      or computers.IPDomainID=domains.ID";
		$q.="  ) as ComputerCount";
		$q.="  , (select count(*)";
		$q.="    from cnames";
		$q.="    where cnames.NameDomainID1=domains.ID";
		$q.="  ) as CnameCount";
		$q.=" from domains";
		$q.=" where domains.ID=".$domainid;
		$q.=";";
		$res=db_q($q,$sock,__FUNCTION__.": reading with counters");
		$ret=db_fetch_object($res);
		db_free_result($res);
		return $ret;
	}
//----------------------------------------------------------
	function ReadNormalDomain($sock,$nameend,$add_counters=false){
		$FUNC="ReadNameDomain";
		$q="select domains.*";
		if($add_counters){
			$q.="  ,( select count(*)";
			$q.="    from computers";
			$q.="    where computers.NameDomainID=domains.ID";
			$q.="  ) as ComputerCount";
			$q.="  , (select count(*)";
			$q.="    from cnames";
			$q.="    where cnames.NameDomainID1=domains.ID";
			$q.="  ) as CnameCount";
		}
		$q.=" from domains";
		$q.=" where DomainType=".DOMAINTYPE_FORWARD." and NameEnd='".addslashes($nameend)."';";
		$res=db_q($q,$sock,$FUNC.": reading");
		if(db_num_rows($res)==1) $domain=db_fetch_object($res);
		else $domain="";
		db_free_result($res);
		return($domain);
	}
//----------------------------------------------------------
	function ReadReverseDomain($sock,$ipbegin,$add_counters=false){
		$FUNC="ReadNameDomain";
		$q="select domains.*";
		if($add_counters){
			$q.="  ,( select count(*)";
			$q.="    from computers";
			$q.="    where computers.IPDomainID=domains.ID";
			$q.="  ) as ComputerCount";
			$q.="  ,0 as CnameCount";
		}
		$q.=" from domains";
		$q.=" where DomainType=".DOMAINTYPE_REVERSE." and IPBegin='".addslashes($ipbegin)."';";
		$res=db_q($q,$sock,$FUNC.": reading");
		if(db_num_rows($res)==1) $domain=db_fetch_object($res);
		else $domain="";
		db_free_result($res);
		return($domain);
	}
//----------------------------------------------------------
	function ReadDomains($sock,$domaintype,$add_counters=false){ // domaintye: 0:all, 1: normal, 2: reverse
		$FUNC="ReadDomains";
		$q="select domains.*";
		if($add_counters){
			$q.="  ,( select count(*)";
			$q.="    from computers";
			$q.="    where computers.NameDomainID=domains.ID";
			$q.="      or computers.IPDomainID=domains.ID";
			$q.="  ) as ComputerCount";
			$q.="  , (select count(*)";
			$q.="    from cnames";
			$q.="    where cnames.NameDomainID1=domains.ID";
			$q.="  ) as CnameCount";
		}
		$q.=" from domains";
		if($domaintype!=0)
			$q.=" where DomainType=".$domaintype;
		$q.=" order by DomainType,NameEnd,IPBegin";
		$q.=";";
		$res=db_q($q,$sock,$FUNC.": selecting");
		return ResToDim_Free($res);
	}
//----------------------------------------------------------
	function TouchDomain($sock,$domainid){
		$FUNC="TouchDomain";
		$q="update domains set ModifyD=".TIME." where ID=".$domainid.";";
		db_q($q,$sock,$FUNC.": updating");
	}
?>
