<?
	require_once("engine/roots_common.php");
	switch($func){
		case "roots":{
			if(HasRights("READ|COMPUTERADMIN",$user)==1){
				$roots=ReadRoots($sock);
			} else {
				$result.="Nincs megfelelő jogosultságod.".BR;
				AfterPost("index.php?mode=home");
			}
		} break;
		case "newroot":
		case "trynewroot":
		case "modifyroot":
		case "trymodifyroot":{
			if(HasRights("COMPUTERADMIN")==1){
				require_once("engine/roots_admin.php");
				if($func=="modifyroot" || $func=="trymodifyroot"){
					$rootid=floor(REQV("rootid",0)+0);
					$root=ReadRoot($sock,$rootid);
					if(!is_object($root)){
						$result.="Nincs ilyen rendszergazda.".BR;
						AfterPost("index.php?mode=rootadmin&func=roots");
					}
				} else $rootid=0;
				if($func=="modifyroot"){
					$realname=$root->RealName;
					$rootbuilding=$root->Building;
					$rootroom=$root->Room;
					$email=$root->Email;
					$personalid=$root->PersonalID;
				} else {
					$realname=trim(REQV("realname",""));
					$rootbuilding=trim(REQV("rootbuilding",""));
					$rootroom=trim(REQV("rootroom",""));
					$email=trim(REQV("email",""));
					$personalid=trim(REQV("personalid",""));
				}
				if($func=="trymodifyroot" || $func=="trynewroot"){
					if($realname=="") $result.="Nincs megadva a rendszergazda neve.".BR;
					if($rootbuilding=="") $result.="Nincs megadva az épület.".BR;
					if($rootroom=="") $result.="Nincs megadva a szobaszám.".BR;
					if($email==""){
						$result.="Nincs megadva e-mail cím!".BR;
					} else {
						if(strpos($email,"@")."x"=="x") $result.="Nincs '@' az e-mail címben.".BR;
						if(strpos($email,".")."x"=="x") $result.="Nincs pont e-mail címben.".BR;
						$r=ReadRootByEmail($sock,$email);
						if(is_object($r) && $r->ID!=$rootid) $result.="Az e-mail cím nem egyedi.".BR;
					}
					$result.=CheckPersonalID($sock,$rootid,$personalid);
					if($result==""){
						if($func=="trynewroot"){
							$root=CreateRoot($sock,$user,$realname,$rootbuilding,$rootroom,$email,$personalid);
							$output.="Új rendszergazda létrehozva.".BR;
						}
						if($func=="trymodifyroot"){
							ModifyRoot($sock,$user,$rootid,$realname,$rootbuilding,$rootroom,$email,$personalid);
							$output.="Rendszergazda módosítva.".BR;
						}
						AfterPost("index.php?mode=rootadmin&func=roots#root_".$root->ID);
					} else $func=substr($func,3);
				} // end of try
			} else {
				$result.="Nincs megfelelő jogosultságod.".BR;
				AfterPost("index.php?mode=home");
			}
		} break;
		case "delroot":
		case "trydelroot":{
			if(HasRights("COMPUTERADMIN")==1){
				require_once("engine/roots_admin.php");
				$rootid=floor(REQV("rootid",0)+0);
				$root=ReadRoot($sock,$rootid);
				if(!is_object($root)){
					$result.="Nincs ilyen rendszergazda.".BR;
					AfterPost("index.php?mode=rootadmin&func=roots");
				}
				if($func=="trydelroot"){
					DeleteRoot($sock,$user,$root);
					$output.="Rendszergazda törölve.".BR;
					AfterPost("index.php?mode=rootadmin&func=roots");
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
