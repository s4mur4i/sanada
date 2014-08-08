<?
	define("COMPUTERS_ORDERCOUNT",8);
	$orders=array();
	for($i=0; $i<8; ++$i)
		$orders[$i]=new stdClass;
	$orders[0]->Name="IP";                          $orders[0]->SQL="b.IPBegin, IPEndNumeric";
	$orders[1]->Name="Gépnév";                      $orders[1]->SQL="NameBegin, c.NameEnd";
	$orders[2]->Name="Rendszergazda neve";          $orders[2]->SQL="RealName";
	$orders[3]->Name="Rendszergazda EHA-kódja";     $orders[3]->SQL="PersonalID";
	$orders[4]->Name="Rendszergazda szobája";       $orders[4]->SQL="RootBuilding, RootRoom";
	$orders[5]->Name="Gép szobája";                 $orders[5]->SQL="Building, Room";
	$orders[6]->Name="Regisztrálás dátuma";         $orders[6]->SQL="CreateD";
	$orders[7]->Name="Módosítás dátuma";            $orders[7]->SQL="ModifyD";

	require_once("engine/computers_common.php");
//----------------------------------------------------------
	function SearchComputers($sock,$search,$orderby="",$ban=-1,$validitystate=-1,$reftimed=0,$accessclass=-1){
		global $orders,$db_error,$result;
		if($reftimed==0) $reftimed=TIME;
	
		$FUNC="SearchComputers";
		$q="select a.*,concat(b.IPBegin,'.',a.IPEnd) as IP,concat(a.NameBegin,'.',c.NameEnd) as Name";
		$q.=",d.RealName,d.Building as RootBuilding,d.Room as RootRoom,d.Email,(a.IPEnd+0) as IPEndNumeric,d.PersonalID";
		$q.=" from computers a left join domains b on a.IPDomainID=b.ID left join domains c on a.NameDomainID=c.ID left join roots d on a.RootID=d.ID";
		$q.=" where (";
		$q.=" concat(b.IPBegin,'.',a.IPEnd) rlike '".addslashes($search)."'";
		$q.=" or concat(a.NameBegin,'.',c.NameEnd) rlike '".addslashes($search)."'";
		$q.=" or RealName rlike '".addslashes($search)."'";
		$q.=" or concat(a.Building,'/',a.Room) rlike '".addslashes($search)."'";
		$q.=" or concat(d.Building,'/',d.Room) rlike '".addslashes($search)."'";
		$q.=" or PersonalID rlike '".addslashes($search)."'";
		$q.=" or Email rlike '".addslashes($search)."'";
		$q.=" or HWAddr rlike '".addslashes($search)."'";
		$q.=" )";
		if($ban==0){
			$q.=" and (BannedUntilD=0 or BannedUntilD<=".TIME.")";
		}
		if($ban==1){
			$q.=" and BannedUntilD!=0 and BannedUntilD>".TIME;
		}
		$q.=" and ".q_ValidityState($validitystate,$reftimed);
		if($accessclass!=-1){
			$q.=" and AccessClass=".$accessclass;
		}
		if($orderby=="") $orderby=$orders[0]->SQL;
		$q.=" order by ".$orderby;
		$q.=";";
		$db_error="";
		$res=db_q($q,$sock,$FUNC.": selecting",1); // skiperror=1
		if($db_error!=""){
			$result.="Érvénytelen regexp kifejezés: '".ToHTML($search)."'".BR;
			return(array());
		} else return(ResToDim_Free($res));
	}
?>
