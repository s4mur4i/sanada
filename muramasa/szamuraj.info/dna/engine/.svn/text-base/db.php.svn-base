<?
	require("engine/db_mysql.php");
	$db_error="";
//----------------------------------------------------------
	function db_q($q,$sock,$msg,$skiperror=0){
		global $db_error;
		$res=db_query($q,$sock);
		if($res<=0){
			if($skiperror==1)
				$db_error.=$msg.": ".db_error($sock)." --- q=".$q."\n";
			else
				sys_Critical("DATABASE ERROR: ".$msg.": ".db_error($sock)." --- q=".$q);
		}
		return($res);
	}
//----------------------------------------------------------
	function db_time($sock){
		$timeres=db_q("select UNIX_TIMESTAMP() as Time;",$sock,"db_time()");
		$timerow=db_fetch_object($timeres);
		db_free_result($timeres);
		$time=$timerow->Time;
		return($time);
	}
//----------------------------------------------------------
	function db_lock($sock,$tablesexpr){ // tablesexpr example: "users write as a, computers as b read"
		$q="lock tables ".$tablesexpr.";";
		db_q($q,$sock,__FUNCTION__.": locking tables ".$tablesexpr);
	}
//----------------------------------------------------------
	function db_unlock($sock){
		$q="unlock tables;";
		db_q($q,$sock,__FUNCTION__.": unlocking tables");
	}
//----------------------------------------------------------
	function db_RecordByID($sock,$table,$id){
		$FUNC="db_RecordByID";
		$q="select * from ".$table." where ID='".addslashes($id)."';";
		$res=db_q($q,$sock,$FUNC.": reading record from ".$table." by id ".$id." '".$q."'");
		if(db_num_rows($res)==1){
			$row=db_fetch_object($res);
		} else $row="";
		db_free_result($res);
		return($row);
	}
//----------------------------------------------------------
	function db_RecordByField($sock,$table,$field,$value){
		$FUNC="db_RecordByField";
		$q="select * from ".$table." where ".$field."='".addslashes($value)."';";
		$res=db_q($q,$sock,$FUNC.": reading record from ".$table." by field ".$field." = ".addslashes($value));
		if(db_num_rows($res)==1){
			$row=db_fetch_object($res);
		} else $row="";
		db_free_result($res);
		return($row);
	}
//----------------------------------------------------------
	function db_GetVar($sock,$name){
		$FUNC="GetVar";
		$q="select * from variables where Name='".addslashes($name)."';";
		$res=db_q($q,$sock,$FUNC.": reading variable ".$name);
		if(db_num_rows($res)==1){
			$row=db_fetch_object($res);
			$ret=$row->Value;
		} else $ret="";
		db_free_result($res);
		return($ret);		
	}
//----------------------------------------------------------
	function db_ReadVar($sock,$name){
		$FUNC="ReadVar";
		$q="select * from variables where Name='".addslashes($name)."';";
		$res=db_q($q,$sock,$FUNC.": getting variable ".$name);
		if(db_num_rows($res)==1){
			$row=db_fetch_object($res);
		} else $row="";
		db_free_result($res);
		return($row);
	}
//----------------------------------------------------------
	function db_SetVar($sock,$name,$value){
		$FUNC="db_SetVar";
		$q="select 1 from variables where Name='".addslashes($name)."';";
		$res=db_q($q,$sock,$FUNC.": searching ".$name);
		if(db_num_rows($res)==0) $q="insert into variables (Name,Value) values ('".$name."','".$value."');";
		if(db_num_rows($res)==1) $q="update variables set Value='".$value."' where Name='".$name."';";
		if(db_num_rows($res)>1){
			 exit("PROGRAMMER ERROR: The 'Name' field of the 'variables' table must be unique key.");
		}
		db_q($q,$sock,$FUNC.": setting variable ".$name);
	}
//----------------------------------------------------------
	function db_ReadVars($sock){
		global $FUNC;
		$q="select * from variables order by Name;";
		return(ResToDim_Free(db_q($q,$sock,$FUNC." selecting variables")));
	}
//----------------------------------------------------------
	function db_GetVars($sock){
		$FUNC="db_GetVars()";
		$q="select * from variables;";
		$res=db_q($q,$sock,$FUNC);
		while($row=db_fetch_object($res)){
			if(defined($row->Name)) exit("PROGRAMMER ERROR: there is a constant name wich conflicts with variables table");
			define ($row->Name,$row->Value);
		}
		db_free_result($res);
	}
//----------------------------------------------------------
	function db_update($sock,$table,$id,$expr){
		$FUNC="db_update";
		$q="update ".$table." set ".$expr." where ID=".$id.";";
		db_q($q,$sock,$FUNC.": ".$q);
	}
//----------------------------------------------------------
	function MyDateToStamp($sock,$date){
		$FUNC="MyDateToStamp";
		$q="select UNIX_TIMESTAMP('".$date."') as Stamp;";
		$res=db_q($q,$sock,$FUNC.": converting");
		$row=db_fetch_object($res);
		db_free_result($res);
		$ret=$row->Stamp;
		return($ret);
	}
?>
