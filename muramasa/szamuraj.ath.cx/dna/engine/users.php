<?
	$logouttime=6;
//----------------------------------------------------------
	function FetchUser($sock,$uid){
		$FUNC="FetchUser";
		$user=db_RecordByID($sock,"users",$uid);
		if($user!="" && $user->DeleteD==0){
			db_update($sock,"users",$user->ID,"TouchD=".time());
			if($user->LoginD<$user->LogoutD || $user->TouchD<=time()-1800){
				if($user->ID!=1){
					Logout($sock,$user->ID);
					$user=FetchUser($sock,1);
				}
				$user->LIN=0;
			} else {
				$user->LIN=1;
			}
		} elseif($uid!=1)
			$user=FetchUser($sock,1);
		return($user);
	}
//----------------------------------------------------------
	function AuthUser($sock,$nick,$pass){
		$FUNC="AuthUser";
		$q="select * from users where Nick='".addslashes($nick)."' and Password=old_password('".addslashes($pass)."') and DeleteD=0;";
		$res=db_q($q,$sock,$FUNC.": ".$nick." trying login");
		if(db_num_rows($res)==1) $luser=db_fetch_object($res);
		else $luser="";
		db_free_result($res);
		return($luser);
	}
//----------------------------------------------------------
	function Login($sock,$sessionid,$nick){
		$FUNC="Login";
		global $logouttime;
		$user=ReadUserByNick($sock,$nick);
		if(is_object($user)){
			$user->LoginD=time();
			$user->TouchD=time();
			$user->LIN=1;
			UpdateSession($sock,$sessionid,$user->ID);
			db_update($sock,"users",$user->ID,"LoginD=".$user->LoginD.",TouchD=".$user->TouchD);
		}
		return($user);
	}
//----------------------------------------------------------
	function Logout($sock,$uid){
		$FUNC="Logout";
		db_update($sock,"users",$uid,"LogoutD=".time());
		EndSession($sock,$uid);
		CreateSession($sock,SIDNAME);
	}
//----------------------------------------------------------
	function OnlineUserCount($sock){
		$FUNC="OnlineUserCount";
		global $logouttime;
		$q="select 1 from users where LoginD>=LogoutD and TouchD>=".(time()-($logouttime*60)).";";
		$res=db_q($q,$sock,$FUNC.": couting");
		$n=db_num_rows($res);
		db_free_result($res);
		return($n);
	}
//----------------------------------------------------------
	function ReadUserByNick($sock,$nick){
		$ret=db_RecordByField($sock,"users","Nick",$nick);
		return($ret);
	}
//----------------------------------------------------------
	function UserRightsToArray($sock,$rights){
		$FUNC="UserRightsToArray";
		
		$ret=Array();
		$tmp=explode("+",$rights);
		$q="select * from rights where ID in (";
		for($i=0;$i<count($tmp);$i++){
			if($i>0) $q.=",";
			$q.="'".$tmp[$i]."'";
		}
		$q.=") order by Name;";
		$ret=ResToDim_Free(db_q($q,$sock,$FUNC.": reading rights"));
		return($ret);
	}
//----------------------------------------------------------
	function ReadAllRights($sock){
		$FUNC="ReadAllRights";
		$q="select * from rights order by Name;";
		$res=db_q($q,$sock,$FUNC.": selecting");
		return(ResToDim_Free($res));
	}
//----------------------------------------------------------
	function HasRights($rights,$userobj="*default*"){
		global $user,$debugtxt;
		if($userobj=="*default*") $userobj=$user;
		$ok=1;
		if(isSubStr("+".strtoupper($userobj->Rights)."+","+BYPASS+")!=1){
			$req=explode("+",strtoupper($rights));
			for($i=0;$i<count($req) && $ok;$i++){
				if($req[$i]){
					$orreq=explode("|",$req[$i]);
					$granted=0;
					for($j=0;$j<count($orreq) && !$granted;$j++){
						if($j>0) $debugtxt.=" or ";
						if(substr($orreq[$i],0,1)=="!"){
							if(IsSubStr("+".strtoupper($userobj->Rights)."+","+".substr($orreq[$j],1)."+")==1) $ortag_ok=0;
							else $ortag_ok=1;
						} else {
							if(IsSubStr("+".strtoupper($userobj->Rights)."+","+".$orreq[$j]."+")==1) $ortag_ok=1;
							else $ortag_ok=0;
						}
						$granted|=$ortag_ok;
					}
					$ok&=$granted;
				}
			}
		}
		return($ok);
	}
//----------------------------------------------------------
	function SetUserRights($sock,$userid,$rights){
		$FUNC="SetUserRigths";
		$q="update users set Rights='".addslashes($rights)."' where ID=".$userid.";";
		db_q($q,$sock,$FUNC.": updating");
	}
//----------------------------------------------------------
	function ReadRight($sock,$rightid){
		$ret=db_RecordByID($sock,"rights",$rightid);
		return($ret);
	}
//----------------------------------------------------------
	function ReadUsers($sock){
		$FUNC="ReadUsers";
		$q="select * from users where Nick!='Anonymous' order by RealName;";
		$res=db_q($q,$sock,$FUNC.": selecting");
		return(ResToDim_Free($res));
	}
//----------------------------------------------------------
	function ReadUser($sock,$luserid,$force=0){
		$FUNC="ReadUser";
		if($force==1) $ret=db_RecordByID($sock,"users",$luserid);
		else {
			$q="select * from users where ID=".$luserid." and Nick!='Anonymous';";
			$res=db_q($q,$sock,$FUNC.": reading");
			if(db_num_rows($res)==1) $ret=db_fetch_object($res);
			else $ret="";
			db_free_result($res);
		}
		return($ret);
	}
//----------------------------------------------------------
	function DelUser($sock,$uid){
		$FUNC="DelUser";
		$q="update users set DeleteD=".TIME." where ID=".$uid.";";
		db_q($q,$sock,$FUNC.": updating");
	}
//----------------------------------------------------------
	function UndelUser($sock,$uid){
		$FUNC="DelUser";
		$q="update users set DeleteD=0 where ID=".$uid.";";
		db_q($q,$sock,$FUNC.": updating");
	}
?>
