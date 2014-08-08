<?
	if(HasRights("READ|USERADMIN")!=1){
		$result.="Nincs megfelelő jogosultságod.".BR;
		AfterPost("index.php?mode=home");
		return;
	}
	if($func=="")
		$func="list";
	switch($func){
		case "list":{
			$variables=db_ReadVars($sock);
		} break;
		case "modify": case "trymodify":{
			if(HasRights("USERADMIN")!=1){
				$result.="Nincs megfelelő jogosultságod.".BR;
				AfterPost("index.php?mode=variables");
				return;
			}
			$name=REQV("name","");
			$variable=db_ReadVar($sock,$name);
			if(!is_object($variable)){
				$result.="Nincs ilyen beállítás.".BR;
				AfterPost("index.php?mode=variables");
				return;
			}
			if($func=="modify"){
				$value=$variable->Value;
			} else {
				$value=REQV("value","");
			}
			if($func=="trymodify"){
				db_SetVar($sock,$name,$value);
				$output.="Elmentve.";
				AfterPost("index.php?mode=variables");;
			}
		} break;
		default: {
			$result.="Érvénytelen funkció '".ToHTML($mode)."' / '".ToHTML($func)."'".BR;
			$mode="blank";
		} break;
	}
?>
