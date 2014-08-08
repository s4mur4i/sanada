<?
	require_once("engine/computers_admin.php");
	switch($func){
		case "paymenu":{
			if(HasRights("COMPUTERADMIN")!=1){
				$result.="Nincs megfelelő jogosultságod.".BR;
				AfterPost("index.php?mode=home");
			}
		} break;
		case "delallunpayed":
		case "trydelallunpayed":{
			if(HasRights("COMPUTERADMIN")==1){
				$computers=ReadComputersByValidityState($sock,VALIDITYSTATE_INVALID);
				if(count($computers)==0){
					$result.="Minden gép \"fizetési státusz\"-a \"rendezett\".<BR>";
					AfterPost("index.php?mode=masspaymentadmin&func=paymenu");
				}
				if($func=="trydelallunpayed"){
					DeleteUnpayedComputers($sock,$user);
					$output.="Törlés kész.<BR>";
					AfterPost("index.php?mode=masspaymentadmin&func=paymenu");
				}
			} else {
				$result="Nincs megfelelő jogosultságod.";
				AfterPost("index.php?mode=home");
			}
		} break;
		default:{
			$result.="Érvénytelen funkció '".ToHTML($mode)."' / '".ToHTML($func)."'".BR;
			$mode="blank";
		} break;
	}
?>
