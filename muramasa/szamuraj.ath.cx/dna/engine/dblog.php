<?
	require_once("engine/db.php");
	require_once("engine/utils.php");
	define("DBLOG_WEIGHT_NORMAL",1);
	define("DBLOG_WEIGHT_WARNING",2);

	define("BANLOG_EVENTTYPE_BAN",1);
	define("BANLOG_EVENTTYPE_UNBAN",2);
	define("BANLOG_EVENTTYPE_LIMIT",3);
	define("BANLOG_EVENTTYPE_UNLIMIT",4);
//----------------------------------------------------------
	function dblog_Append($sock,$weight,$user,$event,$params){
		if($user==NULL){
			$user=FetchUser($sock,1);
		}
		$FUNC="dblog_Append";
		$q="insert into log set";
		$q.=" Weight=".$weight;
		$q.=",EventD=".TIME;
		$q.=",UserID=".$user->ID;
		$q.=",UserNick='".addslashes($user->Nick)."'";
		$q.=",UserName='".addslashes($user->RealName)."'";
		$q.=",Event='".addslashes($event)."'";
		$q.=",Params='".addslashes($params)."'";
		$q.=";";
		db_q($q,$sock,$FUNC.": inserting");
	}
//----------------------------------------------------------
	function dblog_Read($sock,$logid){
		$FUNC="dblog_Read";
		$q="select * from log where ID=".$logid.";";
		$res=db_q($q,$sock,$FUNC.": reading");
		if(db_num_rows($res)==1) $ret=db_fetch_object($res);
		else $ret="";
		db_free_result($res);
		return($ret);
	}
//----------------------------------------------------------
	function dblog_List($sock,$t1,$t2,$searchtext=""){
		$FUNC="dblog_Read";
		$q="select * from log";
		$q.=" where EventD>=".$t1." and EventD<".$t2;
		if($searchtext!=""){
			$sta=addslashes($searchtext);
			$q.=" and (";
			$q.="UserNick like '%".$sta."%'";
			$q.=" or ";
			$q.="UserName like '%".$sta."%'";
			$q.=" or ";
			$q.="Event='".$sta."'";
			$q.=" or ";
			$q.="Params like '%".$sta."%'";
			$q.=")";
		}
		$q.=" order by ID desc;";
		$res=db_q($q,$sock,$FUNC.": selecting");
		return(ResToDim_Free($res));
	}
//----------------------------------------------------------
	function ReadBanLog($sock,$t1,$t2){
		$FUNC="ReadBanLog";
		$q="select * from banlog where CreateD>=".$t1." and CreateD<".$t2." order by ID desc;";
		$res=db_q($q,$sock,$FUNC.": reading");
		return(ResToDim_Free($res));
	}
?>
