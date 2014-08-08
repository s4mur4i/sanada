<?
//----------------------------------------------------------
	function db_error( $sock ){
		$err=mysql_error($sock);
		return($err);
	}
//----------------------------------------------------------
	function db_ConnectDB( $dbname,$user,$pass ){
		$sock=mysql_Connect("localhost",$user,$pass);
		if($sock>0){
			$ret=mysql_Select_DB($dbname,$sock);
			if($ret<=0){
				sys_Critical("Error selecting database ".$dbname.", because: ".mysql_error($sock));
				$sock=-1;
			}
		} else {
			sys_Critical("Error connecting to database server, because: ".mysql_error());
		}
		return($sock);
	}
//----------------------------------------------------------
	function db_close($sock){
		mysql_close($sock);
	}
//----------------------------------------------------------
	function db_query( $query,$sock ){
		// sys_log("DEBUG: query: ".$query);
		$res=mysql_query( $query,$sock );
//	if($res<=0) kk_log(db_error($sock));
		return($res);
	}
//----------------------------------------------------------
	function db_insert_id($sock){
		$ret=mysql_insert_id($sock);
		return($ret);
	}
//----------------------------------------------------------
	function db_fetch_object( $res ){
		$row=mysql_fetch_object($res);
//	if($row<=0) kk_log(db_error($sock));
		return($row);
	}
//----------------------------------------------------------
	function db_fetch_array( $res ){
		$row=mysql_fetch_array($res,MYSQL_NUM);
//	if($row<=0) kk_log(db_error($sock));
		return($row);
	}
//----------------------------------------------------------
	function db_fetch_row( $res ){
		$row=mysql_fetch_row($res);
//	if($row<=0) kk_log(db_error($sock));
		return($row);
	}
//----------------------------------------------------------
	function db_data_seek( $res,$pos ){
		mysql_data_seek($res,$pos);
		return($res);
	}
//----------------------------------------------------------
	function db_num_rows( $res ){
		if($res) $n=mysql_num_rows($res);
		return($n);
	}
//----------------------------------------------------------
	function db_free_result( $res ){
		mysql_free_result($res);
	}
?>
