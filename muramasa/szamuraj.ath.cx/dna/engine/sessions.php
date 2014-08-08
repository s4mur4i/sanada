<?
	define("SIDNAME","DNASessionID");
//----------------------------------------------------------
	function FetchSession($sock,$name,$value){
		global $HTMLBASE,$SERVER_NAME,$REQUEST_URI;
		$FUNC="FetchSession";
		$value+=0;
		$q="select * from sessions where Cookie=".$value.";";
		$res=db_q($q,$sock,$FUNC.": searching session");
		if(db_num_rows($res)==1) $ses=db_fetch_object($res);
		else $ses="";
		db_free_result($res);
		if($ses==""){
			$neednew=1;
		} else {
			if($ses->EndD!=0) $neednew=1;
			else $neednew=0;
		}
		if($neednew==1){
			$ses=CreateSession($sock,$name);
			if(getenv("HTTPS")=="on") $sec="s"; else $sec="";
			HTTPRedirect(
				"checkcookie.php?cookie=".urlencode($ses->Cookie)
				."&origin=".urlencode("http".$sec."://".getenv("SERVER_NAME").":".getenv("SERVER_PORT").getenv("REQUEST_URI")));
		}
		return($ses);
	}
//----------------------------------------------------------
	function CreateSession($sock,$name){
		$FUNC="CreateSession";
		$s=explode(" ",microtime());
		$cookie=($s[0]+0)*1000000;
		$ip=addslashes(getenv("REMOTE_ADDR"));
		$host=addslashes(getenv("REMOTE_HOST"));
		$browser=addslashes(getenv("HTTP_USER_AGENT"));
		$q="insert into sessions (BeginD,IP,Host,Browser,Cookie) values";
		$q.="(".time().",'".$ip."','".$host."','".$browser."',".$cookie.");";
		db_q($q,$sock,$FUNC.": creating session");
		$q="select * from sessions where Cookie=".$cookie." and EndD=0;";
		$res=db_q($q,$sock,$FUNC.": reading back sessionid");
		$n=db_num_rows($res);
		if($n==1){
			$row=db_fetch_object($res);
			$row->Cookie=$row->ID*1000000+$cookie;
			setcookie($name,$row->Cookie,time()+365*24*60*60,"/");
			db_update($sock,"sessions",$row->ID,"Cookie=".$row->Cookie);
		} else {
			$row="";
			if($n>1){
				$q="update sessions set EndD=".time()." where Cookie=".$cookie.";";
				db_q($q,$sock,$FUNC.": closing multiple cookie ".$cookie);
			}
		}
		db_free_result($res);
		return($row);
	}
//----------------------------------------------------------
	function EndSession($sock,$uid){
		$FUNC="EndSesion";
		$q="update sessions set EndD=".time()." where UserID=".$uid." and EndD=0;";
		db_q($q,$sock,$FUNC.": closing session");
	}
//----------------------------------------------------------
	function UpdateSession($sock,$id,$uid){
		db_update($sock,"sessions",$id,"UserID=".$uid);
	}
?>
