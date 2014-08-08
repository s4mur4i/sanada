<?
//----------------------------------------------------------
	function DryAuth($sock,$nick,$pass){
		$FUNC="DryAuth";
		$q="select * from users where Nick='".addslashes($nick)."'";
		$q.=" and Password=old_password('".addslashes($pass)."') and DeleteD=0 and ID!=1;";
		$res=db_q($q,$sock,$FUNC.": searching");
		if(db_num_rows($res)==1) $user=db_fetch_object($res);
		else $user="";
		db_free_result($res);
		return($user);
	}
?>
