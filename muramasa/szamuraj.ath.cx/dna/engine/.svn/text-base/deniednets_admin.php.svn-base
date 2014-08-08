<?
	require_once("engine/deniednets_common.php");
//----------------------------------------------------------
	function ReadDeniedNet($sock,$id){
		$FUNC="ReadDeniedNet";
		$q="select a.*";
		$q.=",b.Nick as CreateByUserNick,b.RealName as CreateByUserName";
		$q.=",c.Nick as ModifyByUserNick,c.RealName as ModifyByUserName";
		$q.=" from deniednets a";
		$q.=" left join users b on a.CreateByUserID=b.ID";
		$q.=" left join users c on a.ModifyByUserID=c.ID";
		$q.=" where a.ID=".$id;
		$q.=";";
		$res=db_q($q,$sock,$FUNC.": reading");
		if(db_num_rows($res)==1)
			$ret=db_fetch_object($res);
		else
			$ret="";
		db_free_result($res);
		return $ret;
	}
//----------------------------------------------------------
	function ReadDeniedNetByNetAndMask($sock,$network,$masklength){
		$FUNC="ReadDeniedNetByNetAndMask";
		$q="select a.*";
		$q.=",b.Nick as CreateByUserNick,b.RealName as CreateByUserName";
		$q.=",c.Nick as ModifyByUserNick,c.RealName as ModifyByUserName";
		$q.=" from deniednets a";
		$q.=" left join users b on a.CreateByUserID=b.ID";
		$q.=" left join users c on a.ModifyByUserID=c.ID";
		$q.=" where a.Network='".addslashes($network)."'";
		$q.=" and a.MaskLength=".$masklength;
		$q.=";";
		$res=db_q($q,$sock,$FUNC.": reading");
		if(db_num_rows($res)==1)
			$ret=db_fetch_object($res);
		else
			$ret="";
		db_free_result($res);
		return $ret;
	}
//----------------------------------------------------------
	function DeniedNets_CheckIPSyntax($ip){
		$parts=explode(".",$ip);
		if(count($parts)!=4)
			return false;
		for($i=0;$i<4;$i++){
			$parts[$i]=ltrim($parts[$i],"0");
			if($parts[$i]=="")
				$parts[$i]="0";
			$part=floor($parts[$i]+0);
			if($part.""!=$parts[$i]."")
				return false;
			if($part<0 || $part>255)
				return false;
		}
		return true;
	}
//----------------------------------------------------------
	function DeniedNets_FormatIP($ip){
		$ret="";
		$parts=explode(".",$ip);
		for($i=0;$i<count($parts);$i++){
			if($i>0)
				$ret.=".";
			$ret.=floor($parts[$i]+0);
		}
		return $ret;
	}
//----------------------------------------------------------
	function CreateUpdateDeniedNet($sock,$id,$userid,$network,$masklength,$descr)
	{
		$FUNC="CreateUpdateDeniedNet";
		if($id==0)
			$q="insert into deniednets set";
		else
			$q="update deniednets set";
		$q.=" ModifyByUserID=".$userid;
		$q.=",ModifyD=".TIME;
		if($id==0){
			$q.=",CreateByUserID=".$userid;
			$q.=",CreateD=".TIME;
		}
		$q.=",Network='".addslashes(DeniedNets_FormatIP($network))."'";
		$q.=",MaskLength=".$masklength;
		$q.=",Descr='".addslashes($descr)."'";
		if($id!=0)
			$q.=" where ID=".$id;
		$q.=";";
		db_q($q,$sock,$FUNC.": inserting");
		if($id==0)
			$id=db_insert_id($sock);
		return ReadDeniedNet($sock,$id);
	}
//----------------------------------------------------------
	function RemoveDeniedNet($sock,$id){
		$FUNC="RemoveDeniedNet";
		$q="delete from deniednets where ID=".$id.";";
		db_q($q,$sock,$FUNC.": removing");
	}	
?>
