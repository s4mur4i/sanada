<?
	require_once("engine/computers_common.php");
	require_once("engine/domains_common.php");
	require_once("engine/roots_common.php");
	switch($func){
		case "print":{
			$computerid=floor(REQV("computerid",0)+0);
			$computer=ReadComputer($sock,$computerid);
			if(is_object($computer)){
				$forwdom=ReadDomain($sock,$computer->NameDomainID);
				$revdom=ReadDomain($sock,$computer->IPDomainID);
				$root=ReadRoot($sock,$computer->RootID);
				require("engine/footer.macro.php");
				require("design/engine/computeradmin_computersheet.php");
				exit();
			} else {
				$func="abort";
				$result.="Nem találom a gépet.<BR>";
			}
		} break;
		case "modifycomputer":
		case "trymodifycomputer":
		case "newcomputer":
		case "trynewcomputer":{
			if(HasRights("COMPUTERADMIN",$user)){
				require_once("engine/computers_admin.php");
				if($func=="modifycomputer" || $func=="trymodifycomputer"){
					$computerid=floor(REQV("computerid",0)+0);
					$computer=ReadComputer($sock,$computerid);
					if(!is_object($computer)){
						$result.="Nincs ilyen számítógép.".BR;
						AfterPost("index.php?mode=search&func=search");
					}
				}
				if($func=="newcomputer"){
					$accessclass=ACCESSCLASS_PROTECTED;
					$validuntil_type=1;
					$validuntil_date=NEXT_TERMINATION_DATE;
				}
				if($func=="modifycomputer"){
					$namebegin=$computer->NameBegin;
					$namedomainid=$computer->NameDomainID;
					$ipdomainid=$computer->IPDomainID;
					$ipend=$computer->IPEnd;
					$hwaddr=$computer->HWAddr;
					$building=$computer->Building;
					$room=$computer->Room;
					$rootid=$computer->RootID;
					$accessclass=$computer->AccessClass;
					$isofficial=$computer->IsOfficial;
					$realname="";
					$rootbuilding="";
					$rootroom="";
					$email="";
					$personalid="";
					$do_copy=REQV("do_copy",0)+0;
					if($do_copy==1){
						$func="newcomputer";
						$computerid=0;
						$validuntild=$computer->ValidUntilD;
						if($validuntild==0){
							$validuntil_type=3;
						} else {
							$validuntil_type=2;
							$validuntil_date=StampToDateTime($validuntild);
						}
					}
				}
				if($func!="modifycomputer"){
					$computerid=REQV("computerid",0)+0;
					$ipend=REQV("ipend",0)+0;
					$ipdomainid=REQV("ipdomainid",0)+0;
					$namedomainid=REQV("namedomainid",0)+0;
					$hwaddr=strtoupper(str_replace(":","",REQV("hwaddr","")));
					$namebegin=trim(REQV("namebegin",""));
					$building=trim(REQV("building",""));
					$room=trim(REQV("room",""));
					$accessclass=floor(REQV("accessclass",0)+0);
					$isofficial=(REQV("isofficial",0)==1?1:0);
					
					$validuntil_type=REQV("validuntil_type",0);
					$validuntil_date=REQV("validuntil_date","");
					
					$rootid=REQV("rootid",0)+0;
					$realname=trim(REQV("realname",""));
					$rootbuilding=trim(REQV("rootbuilding",""));
					$rootroom=trim(REQV("rootroom",""));
					$email=trim(REQV("email",""));
					$personalid=trim(REQV("personalid",""));
				}
				if($func=="trymodifycomputer" || $func=="trynewcomputer"){
					if($func=="trynewcomputer"){
						if(!in_array($validuntil_type,array(1,2,3))){
							$result.="Érvénytelen érvényesség típus választás.".BR;
						} else {
							switch($validuntil_type){
								case 1: $validuntild=NEXT_TERMINATION_STAMP; break;
								case 2:{
									$validuntild=MyDateToStamp($sock,$validuntil_date);
									if($validuntild==0)
										$result.="Érvénytelen dátum.".BR;
								} break;
								case 3: $validuntild=0; break;
								default: break;
							};
						}
					} else {
						$validuntild=$computer->ValidUntilD;
					}
					switch($accessclass){
						case ACCESSCLASS_PROTECTED:
						case ACCESSCLASS_ADVANCED:
						case ACCESSCLASS_SERVER:
						case ACCESSCLASS_CUSTOM: break;
						default: $result.="Érvénytelen hozzáférés típus.".BR; break;
					}
					if($rootroom=="" || $rootbuilding==""){
						$rootbuilding=$building;
						$rootroom=$room;
					}
					if($ipend<1 || $ipend>254)
						$result.="Hibás IP cím!".BR;
					if(strlen($hwaddr)!=12)
						$result.="A HW (Mac) cím nem 12 jegyű.".BR;
					if(StringFilter($hwaddr,"0123456789ABCDEF")!=1)
						$result.="Érvénytelen hexadecimális számjegy a HW (Mac) címben.".BR;
					if($room=="")
						$result.="Nincs megadva, hogy hol van a gép.".BR;
					if($namebegin=="")
						$result.="A gépnév megadása kötelező.".BR;
					if(strtolower($namebegin)!=$namebegin)
						$result.="A gépnév nem tartalmazhat nagy betűket".BR;
					$cnames=ReadCnamesByFQDN($sock,$namebegin,$namedomainid);
					if(count($cnames)>0) $result.="Van ilyen CNAME.".BR;
					if($result==""){
						$cs=ReadComputersByHWAddr($sock,$hwaddr);
						if(count($cs)>0){
							$err="";
							for($i=0;$i<count($cs);$i++){
								if($cs[$i]->ID!=$computerid) $err.="Már van MAC address-en bejegyezve gép (".ToHTML($cs[$i]->Name).")".BR;
							}
							if($err!=""){
								$force=REQV("force",0);
								if($force==1)
									$output.=$err;
								else {
									$allow_force=1;
									$result.=$err;
								}
							}
						}
						unset($cs);
						$cs=ReadComputersByFQDN($sock,$namedomainid,$namebegin);
						if(count($cs)>0){
							$err="";
							for($i=0;$i<count($cs);$i++){
								if($cs[$i]->ID!=$computerid) $err.="Már van ilyen néven bejegyezve gép (".ToHTML($cs[$i]->Name).")".BR;
							}
							if($err!=""){
								if($force==1) $output.=$err;
								else {
									$allow_force=1;
									$result.=$err;
								}
							}
						}
						unset($cs);
						$cs=ReadComputersByIP($sock,$ipdomainid,$ipend);
						if(count($cs)>0){
							$err="";
							for($i=0;$i<count($cs);$i++){
								if($cs[$i]->ID!=$computerid) $err.="Már van ilyen IP-címen bejegyezve gép (".ToHTML($cs[$i]->Name).")".BR;
							}
							if($err!=""){
								if($force==1) $output.=$err;
								else {
									$allow_force=1;
									$result.=$err;
								}
							}
						}
					}
					if($result==""){
						if($rootid==-1){
							require_once("engine/roots_admin.php");
							if($realname=="") $result.="Nincs megadva a rendszergazda neve!".BR;
							if($rootroom=="") $result.="Nincs megadva a szobaszám!".BR;
							$result.=CheckPersonalID($sock,0,$personalid);
							if($email==""){
								$result.="Nincs megadva e-mail cím!".BR;
							} else {
								if(strpos($email,"@")."x"=="x") $result.="Nincs '@' az e-mail címben!".BR;
								if(strpos($email,".")."x"=="x") $result.="Nincs pont e-mail címben!".BR;
							}
							if($result=="")
								$root=CreateRoot($sock,$user,$realname,$rootbuilding,$rootroom,$email,$personalid);
						} else {
							$root=ReadRoot($sock,$rootid);
							if($root=="") $result.="Hibás rendszergazda azonosító!".BR;
						}
					}
				}
				if($func=="trymodifycomputer" || $func=="trynewcomputer"){
					if($result==""){
						$revdom=ReadDomain($sock,$ipdomainid);
						$forwdom=ReadDomain($sock,$namedomainid);
						if($func=="trymodifycomputer"){
							TouchDomain($sock,$computer->IPDomainID);
							TouchDomain($sock,$computer->NameDomainID);
						}
						TouchDomain($sock,$ipdomainid);
						TouchDomain($sock,$namedomainid);
						if($func=="trynewcomputer"){
							$computer=CreateComputer($sock,$user,$ipdomainid,$ipend,$namedomainid,$namebegin,$hwaddr,$root->ID,$building,$room,$validuntild,$accessclass,$isofficial);
							AdjustRootComputerCount($sock,$root->ID,1);
							//ide egy sima, fekete-feher html jon, amit ki lehet nyomtatni
							require("design/engine/computeradmin_computersheet.php");
							require("engine/footer.macro.php");
							exit();
						}
						if($func=="trymodifycomputer"){
							$computer=ReadComputer($sock,$computerid);
							if($computer->RootID!=$root->ID){
								AdjustRootComputerCount($sock,$computer->RootID,-1);
								AdjustRootComputerCount($sock,$root->ID,1);
							}
							ModifyComputer($sock,$user,$computerid,$ipdomainid,$ipend,$namedomainid,$namebegin,$hwaddr,$root->ID,$building,$room,$accessclass,$isofficial);
							$output.=$computer->Name." módosítva.".BR;
							AfterPost("index.php?mode=search&func=search");
						}
					} else $func=substr($func,3);
				}
				if($func=="modifycomputer" || $func=="newcomputer"){
					$forwdomains=ReadDomains($sock,DOMAINTYPE_FORWARD);
					$revdomains=ReadDomains($sock,DOMAINTYPE_REVERSE);
					for($i=0;$i<count($revdomains);$i++){
						$revdomains[$i]->freeips=GuessFreeIP3($sock,$revdomains[$i]->ID);
					}
					$roots=ReadRoots($sock);
				}
			} else {
				$result.="Nincs megfelelő jogosultságod.".BR;
				AfterPost("index.php?mode=search&func=search");
			}
		} break;
		case "delcomputer":
		case "trydelcomputer":{
			if(HasRights("COMPUTERADMIN",$user)==1){
				require_once("engine/computers_admin.php");
				$computerid=floor(REQV("computerid",0)+0);
				$computer=ReadComputer($sock,$computerid);
				if(is_object($computer)){
					$root=ReadRoot($sock,$computer->RootID);
				} else {
					$result.="Nincs ilyen gép.".BR;
					AfterPost("index.php?mode=search&func=search");
					return;
				}
				if($func=="trydelcomputer"){
					DeleteComputer($sock,$user,$computer);
					TouchDomain($sock,$computer->IPDomainID);
					TouchDomain($sock,$computer->NameDomainID);
					$output.="Számítógép törölve.".BR;
					AdjustRootComputerCount($sock,$root->ID,-1);
					if($root->ComputerCount==1){
						require_once("engine/roots_admin.php");
						DeleteRoot($sock,$user,$root);
						$output.="Rendszergazda törölve".BR;
					}
					AfterPost("index.php?mode=search&func=search");
				}
				if($func=="delcomputer" && $root->ComputerCount==1){
					$output.="FIGYELEM: Ez a rendszergazda utolsó számítógépe. A rendszergazda is törölve lesz.".BR;
				}
			} else {
				$result.="Nincs megfelelő jogosultságod.".BR;
				AfterPost("index.php?mode=home");
			}
		} break;
		case "modifyvaliduntild":
		case "trymodifyvaliduntild": {
			if(HasRights("COMPUTERADMIN")==1){
				require_once("engine/computers_admin.php");
				$computerid=floor(REQV("computerid",0)+0);
				$computer=ReadComputer($sock,$computerid);
				if(is_object($computer)){
					$root=ReadRoot($sock,$computer->RootID);
				} else {
					$result.="Nincs ilyen gép.".BR;
					AfterPost("index.php?mode=search&func=search");
					return;
				}
				if($func=="modifyvaliduntild"){
					if($computer->ValidUntilD>0){
						$validuntil_type=2;
						$validuntil_date=StampToDateTime($computer->ValidUntilD);
					} else {
						$validuntil_type=3;
						$validuntil_date=NEXT_TERMINATION_DATE;
					}
				}
				if($func=="trymodifyvaliduntild"){
					$validuntil_type=REQV("validuntil_type",0);
					$validuntil_date=REQV("validuntil_date","");
					if(!in_array($validuntil_type,array(2,3))){
						$result.="Érvénytelen érvényesség típus választás.".BR;
					} else {
						switch($validuntil_type){
							case 2:{
								$validuntild=MyDateToStamp($sock,$validuntil_date);
								if($validuntild==0)
									$result.="Érvénytelen dátum.".BR;
							} break;
							case 3: $validuntild=0; break;
							default: break;
						};
					}
					if($result==""){
						SetComputerValidUntild($sock,$user,$computer,$validuntild);
						TouchDomain($sock,$computer->IPDomainID);
						TouchDomain($sock,$computer->NameDomainID);
						$output.="Érvényesség módosítva.".BR;
						AfterPost("index.php?mode=computeradmin&func=modifycomputer&computerid=".$computer->ID);
						return;
					} else $func=substr($func,3);
				}
			} else {
				$result.="Nincs megfelelő jogosultságod.".BR;
				AfterPost("index.php?mode=home");
			}
		} break;
		case "bancomputer":
		case "trybancomputer":
		case "limitcomputer":
		case "trylimitcomputer":{
			if(HasRights("COMPUTERADMIN",$user)==1){
				$do_ban=FALSE; $do_limit=FALSE;
				if(in_array($func,array("bancomputer","trybancomputer")))
					$do_ban=TRUE;
				if(in_array($func,array("limitcomputer","trylimitcomputer")))
					$do_limit=TRUE;
				require_once("engine/computers_admin.php");
				$computerid=REQV("computerid",0)+0;
				$comment=trim(REQV("comment",""));
				$computer=ReadComputer($sock,$computerid);
				if(is_object($computer)){
					$root=ReadRoot($sock,$computer->RootID);
					if($do_ban && $computer->BannedUntilD>TIME){
						$result.="Ez a gép már tiltólistán van.".BR;
						AfterPost("index.php?mode=computeradmin&func=modifycomputer&computerid=".$computer->ID);
					}
					if($do_limit && $computer->LimitedUntilD>TIME){
						$result.="Ez a gép már korlátozó listán van.".BR;
						AfterPost("index.php?mode=computeradmin&func=modifycomputer&computerid=".$computer->ID);
					}
				} else {
					$result.="Nincs ilyen gép.".BR;
					AfterPost("index.php?mode=search&func=search");
				}
				if($func=="bancomputer"){
					$banneduntild=TIME+DEFAULT_BAN_INTERVAL;
				}
				if($func=="limitcomputer"){
					$limiteduntild=TIME+DEFAULT_LIMIT_INTERVAL;
				}
				if($func=="trybancomputer" || $func=="trylimitcomputer"){
					if($do_ban){
						$banneduntild=MyDateToStamp($sock,trim(REQV("banneduntild","")));
						if($banneduntild<TIME) $result.="A megadott időpont a múltban van.".BR;
					}
					if($do_limit){
						$limiteduntild=MyDateToStamp($sock,trim(REQV("limiteduntild","")));
						if($limiteduntild<TIME) $result.="A megadott időpont a múltban van.".BR;
					}
					if($comment=="") $result.="Az indoklást mindenképpen meg kell adni..".BR;
					if($result==""){
						if($do_ban) $entry=BanComputer($sock,$user,$computer,$banneduntild,$comment);
						if($do_limit) $entry=LimitComputer($sock,$user,$computer,$limiteduntild,$comment);
						TouchDomain($sock,$computer->IPDomainID);
						TouchDomain($sock,$computer->NameDomainID);
						$email=new stdClass;
						if($do_ban) $email->Subject="Számítógép időlegesen kitiltva: ".$computer->NameBegin;
						if($do_limit) $email->Subject="Számítógép időlegesen korlátozva: ".$computer->NameBegin;
						$email->isMultipartAlternative=1;
						$email->ReplyTo=CONFIG_BANEMAIL_REPLYTO;
						ob_start();
						if($do_ban) require("engine/banemail_template.php");
						if($do_limit) require("engine/limitemail_template.php");
						$email->parts[1]=new stdClass;
						$email->parts[1]->Text=ob_get_contents();
						ob_end_clean();
						$email->parts[1]->MimeType="text/html; charset=".CFG_DEFAULT_CHARSET;
						
						$email->parts[0]=new stdClass;
						$email->parts[0]->Text=HTMLToText($email->parts[1]->Text,"UTF-8");
						$email->parts[0]->MimeType="text/plain; charset=".CFG_DEFAULT_CHARSET;
						
						$email->To=$computer->RealName." <".$computer->Email.">";
						SendPlainEmail($email);
						$email->To=CONFIG_BANEMAIL_ADDITIONALTO;
						SendPlainEmail($email);
						if($do_ban) $output.="Számítógép időlegesen kitiltva.".BR;
						if($do_limit) $output.="Számítógép időlegesen korlátozva.".BR;
						AfterPost("index.php?mode=computeradmin&func=modifycomputer&computerid=".$computer->ID);
					} else $func=substr($func,3);
				}
			} else {
				$result.="Nincs megfelelő jogosultságod.".BR;
				AfterPost("index.php?mode=home");
			}
		} break;
		case "unbancomputer":
		case "tryunbancomputer":
		case "unlimitcomputer":
		case "tryunlimitcomputer":{
			if(HasRights("COMPUTERADMIN",$user)==1){
				$do_unban=FALSE; $do_unlimit=FALSE;
				if(in_array($func,array("banuncomputer","tryunbancomputer")))
					$do_unban=TRUE;
				if(in_array($func,array("unlimitcomputer","tryunlimitcomputer")))
					$do_unlimit=TRUE;
				require_once("engine/computers_admin.php");
				$computerid=REQV("computerid",0)+0;
				$comment=trim(REQV("comment",""));
				$computer=ReadComputer($sock,$computerid);
				if(is_object($computer)){
					$root=ReadRoot($sock,$computer->RootID);
					if($do_unban && $computer->BannedUntilD==0){
						$result.="Ez a gép nincsen letiltva.".BR;
						AfterPost("index.php?mode=computeradmin&func=modifycomputer&computerid=".$computer->ID);
					}
					if($do_unlimit && $computer->LimitedUntilD==0){
						$result.="Ez a gép nincsen letiltva.".BR;
						AfterPost("index.php?mode=computeradmin&func=modifycomputer&computerid=".$computer->ID);
					}
				} else {
					$result.="Nincs ilyen gép.".BR;
					AfterPost("index.php?mode=search&func=search");
				}
				if($func=="tryunbancomputer" || $func=="tryunlimitcomputer"){
					if($comment=="") $result.="Az indoklást mindenképpen meg kell adni..".BR;
					if($result==""){
						if($do_unban) $entry=UnbanComputer($sock,$user,$computer,$comment);
						if($do_unlimit) $entry=UnlimitComputer($sock,$user,$computer,$comment);
						TouchDomain($sock,$computer->IPDomainID);
						TouchDomain($sock,$computer->NameDomainID);
						$email=new stdClass;
						if($do_unban) $email->Subject="Számítógép letiltása visszavonva: ".$computer->NameBegin;
						if($do_unlimit) $email->Subject="Számítógép korlátozása visszavonva: ".$computer->NameBegin;
						$email->isMultipartAlternative=1;
						$email->ReplyTo=CONFIG_BANEMAIL_REPLYTO;
						ob_start();
						require("engine/banemail_template.php");
						$email->parts[1]=new stdClass;
						$email->parts[1]->Text=ob_get_contents();
						ob_end_clean();
						$email->parts[1]->MimeType="text/html; charset=".CFG_DEFAULT_CHARSET;
						
						$email->parts[0]=new stdClass;
						$email->parts[0]->Text=HTMLToText($email->parts[1]->Text,"UTF-8");
						$email->parts[0]->MimeType="text/plain; charset=".CFG_DEFAULT_CHARSET;
						
						$email->To=$computer->RealName." <".$computer->Email.">";
						SendPlainEmail($email);
						$email->To=CONFIG_BANEMAIL_ADDITIONALTO;
						SendPlainEmail($email);
						if($do_unban) $output.="Számítógép kitiltása leszedve.".BR;
						if($do_unlimit) $output.="Számítógép korlátozása leszedve.".BR;
						AfterPost("index.php?mode=computeradmin&func=modifycomputer&computerid=".$computer->ID);
					} else $func=substr($func,3);
				}
			} else {
				$result.="Nincs megfelelő jogosultságod.".BR;
				AfterPost("index.php?mode=home");
			}
		} break;
		default:{
			$result.="Érvénytelen funkció '".ToHTML($mode)."' / '".ToHTML($func)."'".BR;
			$mode="blank";
		} break;
	}
?>
