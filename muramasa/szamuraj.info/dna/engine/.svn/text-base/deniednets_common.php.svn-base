<?
//----------------------------------------------------------
	function ReadDeniedNets($sock){
		$FUNC="ReadDeniedNets";
		$q="select a.*";
		$q.=",b.Nick as CreateByUserNick,b.RealName as CreateByUserName";
		$q.=",c.Nick as ModifyByUserNick,c.RealName as ModifyByUserName";
		$q.=" from deniednets a";
		$q.=" left join users b on a.CreateByUserID=b.ID";
		$q.=" left join users c on a.ModifyByUserID=c.ID";
		$q.=" order by Network";
		$q.=";";
		$res=db_q($q,$sock,$FUNC.": selecting");
		return ResToDim_Free($res);
	}
?>
