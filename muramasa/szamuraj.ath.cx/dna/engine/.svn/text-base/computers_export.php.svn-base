<?
	require_once("engine/computers_common.php");
//----------------------------------------------------------
	function ReadComputers($sock,$domaintype,$domainid,$orderby="",$validonly=0){ // domaintype: 0:all computers, 1,2,...:computers from a domain
		$FUNC="ReadComputers";
		$q="select a.*,a.IPEnd+0 as SORT1,concat(b.IPBegin,'.',a.IPEnd) as IP,concat(a.NameBegin,'.',c.NameEnd) as Name";
		$q.=",d.RealName,d.Building as RootBuilding,d.Room as RootRoom,d.Email,d.PersonalID";
		$q.=" from computers a,domains b,domains c,roots d";
		$q.=" where a.IPDomainID=b.ID and a.NameDomainID=c.ID and a.RootID=d.ID";
		if($domaintype==DOMAINTYPE_FORWARD) $q.=" and a.NameDomainID='".addslashes($domainid)."'";
		if($domaintype==DOMAINTYPE_REVERSE) $q.=" and a.IPDomainID='".addslashes($domainid)."'";
		if($validonly==1) $q.=" and (ValidUntilD=0 or ValidUntilD>=".TIME.") and BannedUntilD<".TIME;
		if($orderby!="") $q.=" order by ".$orderby;
		else $q.=" order by b.IPBegin,SORT1";
		$q.=";";
		$res=db_q($q,$sock,$FUNC.": selecting");
		return(ResToDim_Free($res));
	}	
?>
