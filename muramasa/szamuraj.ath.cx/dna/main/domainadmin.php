<?
	require_once("engine/domains_common.php");
	require_once("engine/cnames_common.php");
	switch($func){
		case "domains":{
			if(HasRights("READ|DOMAINADMIN")==1){
				$domains=ReadDomains($sock,0,true); // true: add_counters
				for($i=0;$i<count($domains);$i++){
					$domains[$i]->cnames=ReadCnamesOfDomain($sock,$domains[$i]->ID);
				}
			} else {
				$result.="Nincs megfelelő jogosultságod.".BR;
				AfterPost("index.php?mode=home");
			}
		} break;
		case "modifycname": case "trymodifycname":
		case "newcname": case "trynewcname":{
			require_once("engine/cnames_admin.php");
			if(HasRights("DOMAINADMIN|COMPUTERADMIN")!=1){
				$result.="Nincs megfelelő jogosultságod.".BR;
				AfterPost("index.php?mode=domainadmin&func=domains");
				return;
			}
			if($func=="modifycname" || $func=="trymodifycname"){
				$cnameid=floor(REQV("cnameid",0)+0);
				$cname=ReadCname($sock,$cnameid);
				if(!is_object($cname)){
					$result.="CNAME nem található.".BR;
					AfterPost("index.php?mode=domainadmin&func=domains");
					return;
				}
			} else {
				$cnameid=0;
			}
			if($func=="modifycname"){
				$namedomainid1=$cname->NameDomainID1;
				$namebegin1=$cname->NameBegin1;
				$target=$cname->Target;
				$descr=$cname->Descr;
			} else {
				$namedomainid1=floor(REQV("namedomainid1",0)+0);
				$namebegin1=trim(REQV("namebegin1",""));
				$target=trim(REQV("target",""));
				$descr=trim(REQV("descr",""));
			}
			if($func=="trynewcname" || $func=="trymodifycname"){
				$namedomain1=ReadDomain($sock,$namedomainid1);
				if(!is_object($namedomain1) || $namedomain1->DomainType!=DOMAINTYPE_FORWARD)
					$result.="Forrás domain nem telálható".BR;
				if($namebegin1=="")
					$result.="Forrás név hiányzik.".BR;
				if(strlen($namebegin1)>64)
					$result.="Forrás név túl hosszú.".BR;
				if($target=="")
					$result.="A cél hiányzik.".BR;
				if(strlen($target)>256)
					$result.="A cél túl hosszú.".BR;
				if($result==""){
					$othercname=ReadCnameByAll($sock,$namebegin1,$namedomainid1,$target);
					if(
						($func=="trynewcname" && is_object($othercname))
						||
						($func=="trymodifycname" && is_object($othercname) && $othercname->ID!=$cname->ID)
					){
						$result.="Ponzosan ilyen CNAME már létezik.".BR;
					}
					require_once("engine/computers_common.php");
					$computers=ReadComputersByFQDN($sock,$namedomainid1,$namebegin1);
					if(count($computers)>0){
						$result.="Van ilyen néven bejegyezve gép.".BR;
					}
				}
				if($result=="" && isSubStr($target,".")==1 && substr($target,-1)!="."){
					$err="A célban van pont, de nem pontra végződik.";
					$force=floor(REQV("force",0)+0);
					if($force==1){
						$output.=$err.BR;
					} else {
						$result.=$err.BR;
						$allow_force=1;
					}
				}
				if($result==""){
					TouchDomain($sock,$namedomain1->ID);
					$cname=UpdateCname($sock,$cnameid,$namebegin1,$namedomain1->ID,$target,$descr);
					$output.="A módosításokat elmentettem.".BR;
					AfterPost("index.php?mode=domainadmin&func=domains");
				} else $func=substr($func,3);
			}
			if($func=="newcname" || $func=="modifycname"){
				$forwarddomains=ReadDomains($sock,DOMAINTYPE_FORWARD);
  			}
		} break;
		case "delcname": case "trydelcname":{
			require_once("engine/cnames_admin.php");
			if(HasRights("DOMAINADMIN|COMPUTERADMIN")!=1){
				$result.="Nincs megfelelő jogosultságod.".BR;
				AfterPost("index.php?mode=domainadmin&func=domains");
				return;
			}
			$cnameid=floor(REQV("cnameid",0)+0);
			$cname=ReadCname($sock,$cnameid);
			if(!is_object($cname)){
				$result.="CNAME nem található.".BR;
				AfterPost("index.php?mode=domainadmin&func=domains");
				return;
			}
			if($result=="" && $func=="trydelcname"){ // LOL
				TouchDomain($sock,$cname->NameDomainID1);
				DeleteCname($sock,$cnameid);
				$output.="CNAME törölve.".BR;
				AfterPost("index.php?mode=domainadmin&func=domains");
			}
		} break;
		case "newdomain":
		case "trynewdomain":
		case "modifydomain":
		case "trymodifydomain":{
			require_once("engine/domains_admin.php");
			if(HasRights("DOMAINADMIN",$user)!=1){
				$result.="Nincs megfelelő jogosultságod.".BR;
				AfterPost("index.php?mode=home");
				return;
			}
			if($func=="modifydomain" || $func=="trymodifydomain"){
				$domainid=REQV("domainid",0)+0; 
				$domain=ReadDomain($sock,$domainid);
				if(is_object($domain)){
					$domaintype=$domain->DomainType;
					$ipbegin=$domain->IPBegin;
					$nameend=$domain->NameEnd;
					if($func=="modifydomain"){
						$ttl=$domain->TTL;
						$soaserver=$domain->SOAServer;
						$soaemail=$domain->SOAEmail;
						$soarefresh=$domain->SOARefresh;
						$soaretry=$domain->SOARetry;
						$soaexpire=$domain->SOAExpire;
						$soanegttl=$domain->SOANegTTL;
						$text=$domain->Text;
						$clientconfig=$domain->ClientConfig;
					}
				} else {
					$result.="Nincs ilyen domain.".BR;
					AfterPost("index.php?mode=domainadmin&func=domains");
					return;
				}
			} else {
				$domainid=0;
				$domaintype=floor(REQV("domaintype",0)+0);
				if($domaintype!=DOMAINTYPE_FORWARD && $domaintype!=DOMAINTYPE_REVERSE){
					$result.="A domain-típus megadása kötelező,".BR;
					AfterPost("index.php?mode=domainadmin&func=domains");
					return;
				}
			}
			if($func!="modifydomain"){
				if($func!="trymodifydomain"){
					$ipbegin=trim(REQV("ipbegin",""));
					$nameend=trim(REQV("nameend",""));
				}
				$ttl=REQV("ttl",7200)+0;
				$soaserver=trim(REQV("soaserver",""));
				$soaemail=trim(REQV("soaemail",""));
				$soarefresh=REQV("soarefresh",3600)+0;
				$soaretry=REQV("soaretry",1000)+0;
				$soaexpire=REQV("soaexpire",604800)+0;
				$soanegttl=REQV("soanegttl",7200)+0;
				$soaemail=str_replace("@",".",REQV("soaemail",""));
				$text=trim(REQV("text",""));
				$clientconfig=trim(REQV("clientconfig",""));
			}
			if($func=="trymodifydomain" || $func=="trynewdomain"){
				if($domaintype==DOMAINTYPE_FORWARD && $nameend=="")
					$result.="Nincs megadva név.".BR;
				if($domaintype==DOMAINTYPE_REVERSE && $ipbegin=="")
					$result.="Nincs megadva IP-kezzdet.".BR;
				if($result==""){
					UpdateDomain($sock,$user,$domainid,$domaintype,$ipbegin,$nameend,$ttl,$soaserver,$soaemail,$soarefresh,$soaretry,$soaexpire,$soanegttl,$text,$clientconfig);
					$output.="Elmentettem.".BR;
					AfterPost("index.php?mode=domainadmin&func=domains");
				} else
					$func=substr($func,3);
			}
		} break;
		case "deldomain": case "trydeldomain":{
			require_once("engine/domains_admin.php");
			if(HasRights("DOMAINADMIN")!=1){
				$result.="Nincs megfelelő jogosultságod.".BR;
				AfterPost("index.php?mode=domainadmin&func=domains");
				return;
			}
			$domainid=floor(REQV("domainid",0)+0);
			db_lock($sock,"domains write, computers read, cnames read");
			$domain=ReadDomain($sock,$domainid,true); // true: add_counters
			if(!is_object($domain)){
				db_unlock($sock);
				$result.="Nincs ilyen domain.".BR;
				AfterPost("index.php?mode=domainadmin&func=domains");
				return;
			}
			if($domain->ComputerCount!=0)
				$result.="Csak gépek nélküli domain törölhető (gépek: ".$domain->ComputerCount.").".BR;
			if($domain->CnameCount!=0)
				$result.="Csak CNAME-ek nélküli domain törölhető (CNAME-ek: ".$domain->CnameCount.").".BR;
			if($result==""){
				if($func=="trydeldomain"){
					DeleteDomain($sock,$domainid);
					$output.="CNAME törölve.".BR;
					AfterPost("index.php?mode=domainadmin&func=domains");
				}
			} else
				AfterPost("index.php?mode=domainadmin&func=domains");
			db_unlock($sock);
		} break;
		default:{
			$result.="Érvénytelen funkció '".ToHTML($mode)."' / '".ToHTML($func)."'".BR;
			$mode="blank";
		} break;
	}
?>
