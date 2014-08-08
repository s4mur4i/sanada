<?
	exit("INCOMPLETE: " + __FILE__);
	switch($func){
		case "dhcpds":{
			if(HasRights("READ|DOMAINADMIN")==1){
				$domains=ReadDomains($sock,0);
				for($i=0;$i<count($domains);$i++){
					$domains[$i]->cnames=ReadCnamesOfDomain($sock,$domains[$i]->ID);
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
