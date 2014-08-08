<?
	require("engine/header.macro.php");

	require_once("engine/download.php");
	$path=explode("/",getenv("PATH_INFO"));
	$mode=isset($path[1])?$path[1]:"";
	$p1=isset($path[2])?$path[2]:"";
	$p2=isset($path[3])?$path[3]:"";
	$p3=isset($path[4])?$path[4]:"";
//----- AUTH BEGIN
	if (is_null(SRVV("PHP_AUTH_USER",NULL)))
		$mode="noauth";
	else {
		$nick=SRVV("PHP_AUTH_USER","");
		$pass=SRVV("PHP_AUTH_PW","");
		$user=DryAuth($sock,$nick,$pass);
		if($user=="")
			$mode="noauth";
		else
			if(HasRights("TECHEXPORT|USEREXPORT")!=1)
				$mode="noauth";
  	}
//	if($PHP_AUTH_USER!="nil") $mode="noauth";
//----- AUTH DONE
	// OFF SWITCH BEGIN
//	$mode="noauth";
//	$result.="TECHNIKAI SZUNET\n";
	// OFF SWITCH END
	switch($mode){
		case "noauth": break;
		case "deniednets":{
			require_once("engine/deniednets_common.php");
			$deniednets=ReadDeniedNets($sock);
		} break;
		case "domain": case "roots": {
			require_once("engine/domains_common.php");
			if($p1=="normal") $domaintype=DOMAINTYPE_FORWARD;
			else if($p1=="reverse") $domaintype=DOMAINTYPE_REVERSE;
				else {
					$mode="noauth";
					$result="Unknown domain type: '".$domaintype."'. Choose 'normal' or 'reverse'!\n";
				}
			if($mode=="domain" && HasRights("TECHEXPORT")!=1){
				$mode="noauth";
				$result.="Nincs megfelelő jogosultságod.\n";
			}
			if(($mode=="roots") && HasRights("USEREXPORT")!=1){
				$mode="noauth";
				$result.="Nincs megfelelő jogosultságod.\n";
			}
			if($mode=="domain" || $mode=="roots"){
				require_once("engine/domains_export.php");
				$orderby="";
				if($domaintype==DOMAINTYPE_FORWARD){
					$domain=ReadNormalDomain($sock,$p2);
					if(!is_object($domain)){
						$mode="abort";
						$result.="Domain not found: '".$p2."'\n";
					} else
					if($mode=="domain"){
						$mode="normaldomain";
						$orderby="NameBegin";
					}
				}
				if($domaintype==DOMAINTYPE_REVERSE){
					$domain=ReadReverseDomain($sock,$p2);
					if(!is_object($domain)){
						$mode="abort";
						$result.="Domain not found: '".$p2."'\n";
					} else
					if($mode=="domain"){
						$tmp=explode(".",$domain->IPBegin);
						$tmp2="";
						for($i=2;$i>=0;$i--){
							if($i<2) $tmp2.=".";
							$tmp2.=$tmp[$i];
						}
						$tmp2.=".in-addr.arpa";
						$domain->origin=$tmp2;
						$mode="reversedomain";
						$orderby="IPEnd";
					}
				}
				if($result==""){
					if($mode=="normaldomain" || $mode=="reversedomain"){
						require_once("engine/computers_export.php");
						require_once("engine/cnames_common.php");
						$lastexportd_day=date("Ymd",$domain->LastExportD);
						$modifyd_day=date("Ymd",$domain->ModifyD);
						if($domain->LastExportD<=$domain->ModifyD){
							if($lastexportd_day==$modifyd_day)
							{
								if($domain->SOASerial<99)
									$domain->SOASerial++;
							} else
								$domain->SOASerial=1;
						}
						$domain->LastExportD=TIME;
						RegisterDomainExport($sock,$domain->ID,$domain->SOASerial);
						$computers=ReadComputers($sock,$domain->DomainType,$domain->ID,$orderby,0); // validonly=0
						$cnames=ReadCnamesOfDomain($sock,$domain->ID);
					}
					if($mode=="roots"){
						require_once("engine/roots_common.php");
						$roots=ReadRootsByDomain($sock,$domain->ID);
					}
				}
			}
		} break;
		case "dhcpd":
		case "staticarp": case "staticarpac": case "staticarpacb":
		case "staticarphost": case "weblist":
		if(HasRights("TECHEXPORT")==1){
			$ipns=explode(".",$p1); $maskwidth=floor($p2);
			if(count($ipns)!=4){
				$mode="abort";
				$result.="Illegal network address: '".$p1."'.\n";
			} else {
				for($i=0;$i<count($ipns);$i++){
					if(!isset($ipns[$i]) || ($ipns[$i]!="0" && floor($ipns[$i])==0)){
						$result.="Illegal IP numer part ".($i+1).": '".$ipns[$i]."'.\n";
						$mode="abort";
					} else {
						$ipns[$i]=floor($ipns[$i]);
						if($ipns[$i]<0 || $ipns[$i]>255){
							$result.="Illegal IP numer part ".($i+1).": '".$ipns[$i]."'.\n";
							$mode="abort";
						}
					}
				}
			}
			if($maskwidth<16 || $maskwidth>30){
				$mode="abort";
				$result.="Illegal netwok mask '".$p2."'. Must be between 16 and 30.\n";
			}
			if($result=="" && ($mode=="weblist")){
				if(HasRights("USEREXPORT")!=1) $mode="noauth";
			}
			if($result==""){
				$ipvalue=IPToNumber($p1);
				$ipmask=CalcIPMask($maskwidth);
				$ipnetwork=($ipvalue&$ipmask);
				$ipbroadcast=$ipnetwork+(pow(2,32-$maskwidth)-1);
				if($mode=="dhcpd"){
					require_once("engine/dhcpds_export.php");
					$dhcpd=ReadDHCPDByNet($sock,NumberToIP($ipnetwork),$maskwidth);
					if(!is_object($dhcpd)) $output.="DHCP daemon configuration not found in database.\n";
				}
				require_once("engine/computers_export.php");
				$cstemp=ReadComputers($sock,0,0,"",1); // validonly=1
				unset($computers);
				for($i=0;$i<count($cstemp);$i++){
					$ipvalue=IPToNumber($cstemp[$i]->IP);
					if(($ipvalue&$ipmask)-$ipnetwork==0){
						$computers[]=$cstemp[$i];
					}
				}
				unset($cstemp);
			}
		} else {
			$mode="noauth";
			$result.="Nincs megfelelő jogosultságod.\n";
		}
		break;
		case "abort": break;
		default:{
			$result.="Uknown function code: '".$mode."'.\n";
			$mode="abort";
		}
	}
	require_once("engine/footer.macro.php");
	require("design/download.php");
?>
