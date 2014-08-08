<?
	if(HasRights("DOMAINADMIN|COMPUTERADMIN")!=1){
		$result.="Nincs megfelelő jogosultságod.".BR;
		AfterPost("index.php?mode=home");
		return;
	}
	require_once("engine/deniednets_admin.php");
	if($func=="")
		$func="deniednets";
	switch($func){
		case "deniednets": break;
		case "newdeniednet": case "trynewdeniednet":
		case "modifydeniednet": case "trymodifydeniednet":{
			$id=floor(REQV("id",0)+0);
			if($func=="newdeniednet" || $func=="trynewdeniednet")
				$id=0;
			if($func=="modifydeniednet" || $mode=="trymodifydeniednet"){
				$deniednet=ReadDeniedNet($sock,$id);
				if(!is_object($deniednet)){
					$result.="Nincs ilyen tiltott hálózat.".BR;
					AfterPost("index.php?mode=home");
					return;
				}
			}
			if($func=="modifydeniednet"){
				$network=$deniednet->Network;
				$masklength=$deniednet->MaskLength;
				$descr=$deniednet->Descr;
			} else {
				$network=trim(REQV("network",""));
				$masklength=floor(REQV("masklength",0)+0);
				if(substr($func,0,3)!="try" && $masklength==0)
					$masklength=32;
				$descr=trim(REQV("descr",""));
			}
			if($func=="trynewdeniednet" || $func=="trymodifydeniednet"){
				if(!DeniedNets_CheckIPSyntax($network))
					$result.="Érvénytelen hálózati cím.".BR;
				if($masklength<8 || $masklength>32)
					$result.="Érvénytelen címszélesség. Érvényes tartomány: [8..32]".BR;
				if($result==""){
					CreateUpdateDeniedNet($sock,$id,$user->ID,$network,$masklength,$descr);
					$output.="Tiltott hálózat mentve.".BR;
					AfterPost("index.php?mode=deniednetadmin&func=deniednets");
				} else {
					$func=substr($func,3);
				}
			}
		} break;
		case "deldeniednet": case "trydeldeniednet":{
			$id=REQV("id",0)+0;
			$deniednet=ReadDeniedNet($sock,$id);
			if(!is_object($deniednet)){
				$result.="Nincs ilyen tiltott hálózat.".BR;
				AfterPost("index.php?mode=home");
				return;
			}
			if($func=="trydeldeniednet"){
				if($result==""){
					RemoveDeniedNet($sock,$deniednet->ID);
					$output.="Tiltott hálózat törölve.".BR;
					AfterPost("index.php?mode=deniednetadmin&func=deniednets");
				} else {
					$func=substr($func,3);
				}
			}
		} break;
		default:{
			$result.="Érvénytelen funkció '".ToHTML($mode)."' / '".ToHTML($func)."'".BR;
			$mode="blank";
		} break;
	}
	if($func=="deniednets"){
		$deniednets=ReadDeniedNets($sock);
	}
?>
