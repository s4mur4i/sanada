<?
	require("engine/header.macro.php");
	require("engine/session.macro.php");
	$mode=REQV("mode","");
	$func=REQV("func","");

	if($mode!="logout" && $mode!="trylogin" && $mode!="about" && $user->LIN==0)
		$mode="login";

	if(getenv("HTTPS")!="on"){
		$result.="Sima HTTP nem ér!";
		Refresh("https://".getenv("SERVER_NAME").getenv("REQUEST_URI"),3);
		$mode="blank";
	}
	
	if($mode=="") $mode="login";
	
	if(!defined("NEXT_TERMINATION_DATE"))
		define("NEXT_TERMINATION_DATE",0);
	define("NEXT_TERMINATION_STAMP",MyDateToStamp($sock,constant("NEXT_TERMINATION_DATE")));
	if(!defined("NEXT_GRACE_DATE"))
		define("NEXT_GRACE_DATE",0);
	define("NEXT_GRACE_STAMP",MyDateToStamp($sock,constant("NEXT_GRACE_DATE")));
	if(!defined("DEFAULT_BAN_INTERVAL"))
		define("DEFAULT_BAN_INTERVAL",7*24*60*60);
	if(!defined("DEFAULT_LIMIT_INTERVAL"))
		define("DEFAULT_LIMIT_INTERVAL",7*24*60*60);
	
	switch($mode){
		case "login":
		case "trylogin":{
			if($user->LIN==1){
				dblog_Append($sock,DBLOG_WEIGHT_NORMAL,$user,"LOGOUT","UserID=".$user->ID.",UserNick='".addslashes($user->Nick)."'");
				Logout($sock,$user->ID);
				$result.="Be voltál jelentkezve.".BR;
				AfterPost("index.php?mode=login");
			}
			if($mode=="trylogin"){
				$nick=trim(REQV("nick",""));
				$pass=REQV("pass","");
				$luser=AuthUser($sock,$nick,$pass);
				if(is_object($luser)){
					if(HasRights("NOLOGIN",$luser)!=1){
						dblog_Append($sock,DBLOG_WEIGHT_NORMAL,$user,"LOGIN","SessionID=".$session->ID.",SessionIP='".$session->IP."',SessionHost='".$session->Host."',UserID=".$luser->ID.",UserNick='".addslashes($luser->Nick)."'");
						$user=Login($sock,$session->ID,$nick);
						$output.="Sikeres bejelentkezés<BR>";
						AfterPost("index.php?mode=home");
					} else {
						dblog_Append($sock,DBLOG_WEIGHT_WARNING,$user,"LOGIN-DENIED","SessionID=".$session->ID.",SessionIP='".$session->IP."',SessionHost='".$session->Host."',UserID=".$luser->ID.",UserNick='".addslashes($luser->Nick)."'");
						$output.="Sikeres azonosítás. Bejelentkezés megtagadva.<BR>";
						AfterPost("index.php?mode=home");
					}
				} else {
					$result.="Ismeretlen felhasználónév vagy hibás jelszó".BR;
					dblog_Append($sock,DBLOG_WEIGHT_WARNING,$user,"LOGIN-FAILED","SessionID=".$session->ID.",SessionIP='".$session->IP."',SessionHost='".$session->Host."',UserNick='".addslashes($nick)."'");
					AfterPost("index.php?mode=login&nick=".ToURL($nick));
				}
			}
		} break;
		case "logout":{
			if($user->LIN==1){
				dblog_Append($sock,DBLOG_WEIGHT_NORMAL,$user,"LOGOUT","SessionID=".$session->ID.",SessionIP='".$session->IP."',SessionHost='".$session->Host."',UserID=".$user->ID.",UserNick='".addslashes($user->Nick)."'");
				Logout($sock,$user->ID);
				setcookie("cook_search_string","",TIME,"/");
				setcookie("cook_search_ban","",TIME,"/");
				setcookie("cook_search_accessclass","",TIME,"/");
				setcookie("cook_search_validitystate","",TIME,"/");
				setcookie("cook_search_order","",TIME,"/");
				setcookie("cook_search_custom_reftime","",TIME,"/");
				setcookie("cook_search_reftime","",TIME,"/");
				$output.="Köszönjük, hogy nálunk konfigolt!".BR;
			} else {
				$result.="Nem is vagy bejelentkezve.".BR;
			}
			AfterPost("index.php?mode=login");
		} break;
		case "useradmin":
		case "variables":
		case "rootadmin":
		case "computeradmin":
		case "domainadmin":
		case "deniednetadmin":
		case "masspaymentadmin":
		case "newsletter":
		case "viewlog":
		case "search":{
			require("main/".$mode.".php");
		} break;
		case "home": break;
		case "about": break;
		case "blank": break;
		default:{
			$result.="Ismeretlen főfunkció: <TT>".ToHTML($mode)."</TT>".BR;
			$mode="abort";
		} break;
	}
	
	$skipmenu=0;
	if($mode=="login" || $mode=="blank" || $mode=="abort" || $mode=="about" || $mode=="jump") $skipmenu=1;
	
	require("design/index.php");
	require("engine/footer.macro.php");
?>
