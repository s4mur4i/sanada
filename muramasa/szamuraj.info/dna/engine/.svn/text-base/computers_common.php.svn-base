<?
	define("ACCESSCLASS_PROTECTED",1);
	define("ACCESSCLASS_ADVANCED",2);
	define("ACCESSCLASS_SERVER",3);
	define("ACCESSCLASS_CUSTOM",4);
	$d_accessclasses[ACCESSCLASS_PROTECTED]="Védett";
	$d_accessclasses[ACCESSCLASS_ADVANCED]="Haladó";
	$d_accessclasses[ACCESSCLASS_SERVER]="Szerver";
	$d_accessclasses[ACCESSCLASS_CUSTOM]="Egyedi";
	
	define("VALIDITYSTATE_INVALID",1);
	define("VALIDITYSTATE_VALID",2);
	define("VALIDITYSTATE_FOREVER",3);
	$d_validitystates[VALIDITYSTATE_INVALID]="Lejárt";
	$d_validitystates[VALIDITYSTATE_VALID]="Érvényes";
	$d_validitystates[VALIDITYSTATE_FOREVER]="Örökre érvényes";

	require_once("domains_common.php");
//----------------------------------------------------------
	function q_ValidityState($validitystate,$reftimed=0,$table_alias=""){
		if($table_alias!="") $table_alias.=".";
		$q="(";
		switch($validitystate){
			case VALIDITYSTATE_INVALID: $q.=$table_alias."ValidUntilD!=0 and ".$table_alias."ValidUntilD<".$reftimed; break;
			case VALIDITYSTATE_VALID: $q.=$table_alias."ValidUntilD>=".$reftimed; break;
			case VALIDITYSTATE_FOREVER: $q.=$table_alias."ValidUntilD=0"; break;
			default: $q.="1=1"; break;
		}
		$q.=")";
		return $q;
	}
//----------------------------------------------------------
	function ReadComputer($sock,$compid){
		$FUNC="ReadComputer";
		$q="select a.*,concat(b.IPBegin,'.',a.IPEnd) as IP,concat(a.NameBegin,'.',c.NameEnd) as Name";
		$q.=",d.RealName,d.Building as RootBuilding,d.Room as RootRoom,d.Email";
		$q.=" from computers a,domains b,domains c,roots d";
		$q.=" where a.ID=".$compid;
		$q.=" and a.IPDomainID=b.ID and a.NameDomainID=c.ID and a.RootID=d.ID;";
		$res=db_q($q,$sock,$FUNC.": selecting");
		$comp=db_fetch_object($res);
		return($comp);
	}
//----------------------------------------------------------
	function ReadComputersByFQDN($sock,$domainid,$namebegin){
		$FUNC="ReadComputersByFQDN";
		$q="select a.*,concat(b.IPBegin,'.',a.IPEnd) as IP,concat(a.NameBegin,'.',c.NameEnd) as Name";
		$q.=",d.RealName,d.Building as RootBuilding,d.Room as RootRoom,d.Email,(a.IPEnd+0) as IPEndNumeric,d.PersonalID";
		$q.=" from computers a left join domains b on a.IPDomainID=b.ID left join domains c on a.NameDomainID=c.ID left join roots d on a.RootID=d.ID";
		$q.=" where NameDomainID=".$domainid." and NameBegin='".addslashes($namebegin)."';";
		$res=db_q($q,$sock,$FUNC.": selecting");
		return(ResToDim_Free($res));
	}
?>
