<?
//----------------------------------------------------------
	function ReadDHCPDByNet($sock,$network,$maskwidth){
		$FUNC="ReadDHCPDByNet";
		$q="select * from dhcpds where NetBase='".addslashes($network)."' and NetMaskWidth=".$maskwidth.";";
		$res=db_q($q,$sock,$FUNC.": reading");
		if(db_num_rows($res)==1) $dhcpd=db_fetch_object($res);
		else $dhcpd="";
		db_free_result($res);
		return($dhcpd);
	}
?>
