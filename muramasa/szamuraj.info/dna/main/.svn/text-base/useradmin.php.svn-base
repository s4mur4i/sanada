<?
	switch($func){
		case "newuser":
		case "trynewuser":
		case "modifyuser":
		case "trymodifyuser":
		case "modifyself":
		case "trymodifyself":{
			if($func=="modifyself" || $func=="trymodifyself"){
				$luserid=$user->ID;
			} else {
				$luserid=REQV("luserid",0)+0;
			}
			if($func=="modifyuser" || $func=="trymodifyuser" || $func=="newuser" || $func=="trynewuser"){
				if(HasRights("USERADMIN",$user)!=1){
					$result.="Nincs megfelelő jogosultságod felhasználók módosításához.".BR;
					AfterPost("index.php?mode=home");
				}
			}
			if($result=="" && ($func=="modifyuser" || $func=="trymodifyuser" || $func=="modifyself" || $func=="trymodifyself")){
				$luserid=floor($luserid+0);
				$luser=ReadUser($sock,$luserid);
				if(!is_object($luser)){
					$result.="Nincs ilyen felhasználó".BR;
					AfterPost("index.php?mode=useradmin&func=users");
					return;
				}
			}
			if($func=="newuser" || $func=="modifyuser" || $func=="modifyself"){
				require("engine/setvars_user.macro.php");
				$pass1=REQV("pass1","");
				$pass2=REQV("pass2","");
			}
			if($func=="trynewuser" || $func=="trymodifyuser" || $func=="trymodifyself"){
				require("engine/checkdata_user.macro.php");
				if($result==""){
					require("engine/submitdata_user.macro.php");
					if($func=="trynewuser") $output.="Felhasználó létrehozva.".BR;
					else $output.="Módosítások elmentve.".BR;
					if($func=="trymodifyself")
						AfterPost("index.php?mode=home");
					else
						AfterPost("index.php?mode=useradmin&func=users");
				} else $func=substr($func,3);
			}
			if($func=="modifyuser" || $func=="modifyself" || $func=="newuser"){
				$allrights=ReadAllRights($sock);
			}
		} break;
		case "deluser":
		case "trydeluser":{
			if(HasRights("USERADMIN",$user)==1){
				$luserid=floor($luserid+0);
				$luser=ReadUser($sock,$luserid);
				if(!is_object($luser)){
					$result.="Nincs ilyen felhasználó".BR;
					AfterPost("index.php?mode=useradmin&func=users");
				} else {
					if($luser->DeleteD>0){
						$result.="Ez a felhasználó már törölve van.";
						AfterPost("index.php?mode=useradmin&func=modifyuser&luserid=".$luser->ID);
					}
				}
				if($func=="trydeluser"){
					DelUser($sock,$luser->ID);
					$output.="Törölve".BR;
					AfterPost("index.php?mode=useradmin&func=users");
				}
			} else {
				$result.="Nincs megfelelő jogosultságod.".BR;
				AfterPost("index.php?mode=home");
			}
		} break;
		case "undeluser":
		case "tryundeluser":{
			if(HasRights("USERADMIN",$user)==1){
				$luserid=floor($luserid+0);
				$luser=ReadUser($sock,$luserid);
				if(!is_object($luser)){
					$result.="Nincs ilyen felhasználó".BR;
					AfterPost("index.php?mode=useradmin&func=users");
				} else {
					if($luser->DeleteD==0){
						$result.="Ez a felhasználó nincsen törölve.";
						AfterPost("index.php?mode=useradmin&func=modifyuser&luserid=".$luser->ID);
					}
				}
				if($func=="tryundeluser"){
					UndelUser($sock,$luser->ID);
					$output.="Visszaállítva".BR;
					AfterPost("index.php?mode=useradmin&func=users");
				}
			} else {
				$result.="Nincs megfelelő jogosultságod.".BR;
				AfterPost("index.php?mode=home");
			}
		} break;
		case "users":{
			if(HasRights("USERADMIN",$user)==1){
				$users=ReadUsers($sock);
				$allrights=ReadAllRights($sock);
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
