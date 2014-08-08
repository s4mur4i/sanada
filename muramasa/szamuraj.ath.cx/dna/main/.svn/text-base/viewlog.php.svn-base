<?
	if(HasRights("READ")!=1){
		$result.="Nincs megfelelő jogosultságod.".BR;
		AfterPost("index.php?mode=home");
		return;
	}
	switch($func){
		case "banlog":{
			$t1=REQV("t1","");
			$t2=REQV("t2","");
			if($t1==""){
				$t1=StampToDateTime(TIME-365*24*60*60);
				$t2=StampToDateTime(TIME);
			}
			$t1=MyDateToStamp($sock,trim($t1));
			$t2=MyDateToStamp($sock,trim($t2));
			$banlog=ReadBanLog($sock,$t1,$t2);
		} break;
		case "syslog":{
			$t1=REQV("t1",0)+0;
			$t2=REQV("t2",0)+0;
			if($t1==0){
				$t1=TIME-30*24*60*60;
				$t2=TIME;
			}
			$t1=floor($t1+0);
			$t2=floor($t2+0);
			$dblog=dblog_List($sock,$t1,$t2);
		} break;
		default:{
			$result.="Érvénytelen funkció '".ToHTML($mode)."' / '".ToHTML($func)."'".BR;
			$mode="blank";
		} break;
	}
?>
