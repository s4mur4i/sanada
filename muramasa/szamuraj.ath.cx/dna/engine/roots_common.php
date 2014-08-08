<?
//----------------------------------------------------------
	function ReadRoot($sock,$id){
		$FUNC="ReadRoot";
		$root=db_RecordByID($sock,"roots",$id);
		return($root);
	}
//----------------------------------------------------------
	function ReadRootsByDomain($sock,$domainid){ // domaintye: 0:all, 1: normal, 2: reverse
		$FUNC="ReadRootsByDomain";
		$q="select b.* from computers a left join roots b on a.RootID=b.ID where ";
		if($domainid>0) $q.="(NameDomainID=".$domainid." or IPDomainID=".$domainid.") and ";
		$q.="ComputerCount>0 and Email is not null and Email!='' group by b.ID order by b.RealName;";
        $res=db_q($q,$sock,$FUNC."selecting roots");
		return(ResToDim_Free($res));
	}
//----------------------------------------------------------
	function ReadRootsByComputers($sock,&$computers){ // Refernce for speed
		$FUNC="ReadRootsByComputers";
		$idlist="-1";
		for($i=0;$i<count($computers);$i++){
			$idlist.=",";
			$idlist.=$computers[$i]->RootID;
		}
		$q="select b.*";
		$q.=" from roots b";
		$q.=" where b.ID in (".$idlist.")";
		$q.="  and Email is not null";
		$q.="  and Email!=''";
		$q.=" group by b.ID";
		$q.=" order by b.RealName";
		$q.=";";
		return ResToDim_Free(db_q($q,$sock,$FUNC.": selecting"));
	}
//----------------------------------------------------------
	function ReadRoots($sock){
		$FUNC="ReadRoots";
		$q="select * from roots order by RealName;";
		$res=db_q($q,$sock,$FUNC.": selecting");
		return(ResToDim_Free($res));
	}
//----------------------------------------------------------
	function AdjustRootComputerCount($sock,$rootid,$delta){
		$FUNC="AdjustRootComputerCount";
		$q="update roots set ComputerCount=ComputerCount+(".$delta.") where ID=".$rootid.";";
		db_q($q,$sock,$FUNC.": updating");
	}
?>
