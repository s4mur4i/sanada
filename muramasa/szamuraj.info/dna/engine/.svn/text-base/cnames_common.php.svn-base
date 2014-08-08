<?
//----------------------------------------------------------
	function ReadCname($sock,$cnameid){
		$FUNC="ReadCname";
		$q="select a.*,b.NameEnd as NameEnd1";
		$q.=" from cnames a,domains b";
		$q.=" where a.ID=".$cnameid;
		$q.=" and a.NameDomainID1=b.ID";
		$q.=";";
		$res=db_q($q,$sock,$FUNC.": reading");
		if(db_num_rows($res)==1) $cname=db_fetch_object($res);
		else $cname="";
		db_free_result($res);
		return($cname);
	}
//----------------------------------------------------------
	function ReadCnames($sock){
		$FUNC="ReadCnames";
		$q="select a.*,b.NameEnd as NameEnd1";
		$q.=" from cnames a,domains b";
		$q.=" where a.NameDomainID1=b.ID";
		$q.=" order by NameEnd1,Target,NameBegin1";
		$q.=";";
		$res=db_q($q,$sock,$FUNC.": reading");
		return(ResToDim_Free($res));
	}
//----------------------------------------------------------
	function ReadCnamesOfDomain($sock,$domainid1){
		$FUNC="ReadCnamesOfDomain";
		$q="select a.*,b.NameEnd as NameEnd1";
		$q.=" from cnames a,domains b";
		$q.=" where a.NameDomainID1=".$domainid1;
		$q.=" and a.NameDomainID1=b.ID";
		$q.=" order by NameEnd1,Target,NameBegin1";
		$q.=";";
		$res=db_q($q,$sock,$FUNC.": reading");
		return(ResToDim_Free($res));
	}
//----------------------------------------------------------
	function ReadCnameByAll($sock,$namebegin1,$namedomainid1,$target){
		$FUNC="ReadCnameByAll";
		$q="select a.*";
		$q.=" from cnames a,domains b";
		$q.=" where a.NameBegin1='".addslashes($namebegin1)."'";
		$q.=" and a.NameDomainID1=".$namedomainid1;
		$q.=" and a.Target='".addslashes($target)."'";
		$q.=" and a.NameDomainID1=b.ID";
		$q.=";";
		$res=db_q($q,$sock,$FUNC.": reading");
		if(db_num_rows($res)==1) $cname=db_fetch_object($res);
		else $cname="";
		db_free_result($res);
		return($cname);
	}
//----------------------------------------------------------
	function ReadCnamesByFQDN($sock,$namebegin1,$namedomainid1){
		$FUNC="ReadCnameByAll";
		$q="select a.*";
		$q.=" from cnames a,domains b";
		$q.=" where a.NameBegin1='".addslashes($namebegin1)."'";
		$q.=" and a.NameDomainID1=".$namedomainid1;
		$q.=" and a.NameDomainID1=b.ID";
		$q.=";";
		$res=db_q($q,$sock,$FUNC.": reading");
		return(ResToDim_Free($res));
	}
?>
