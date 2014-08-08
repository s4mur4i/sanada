<?
	require_once("engine/cnames_admin.php");
//----------------------------------------------------------
	function UpdateCname($sock,$cnameid,$namebegin1,$namedomainid1,$target,$descr){
		global $user;
		if($cnameid==0){
			$FUNC="CreateCname";
			$q="insert into cnames set";
			$q.=" CreateD=".TIME;
			$q.=",CreatedByUserID=".$user->ID;
		} else {
			$FUNC="ModifyCname";
			$q="update cnames set";
			$q.=" ModifyD=".TIME;
			$q.=",ModifiedByUserID=".$user->ID;
		}
		$q.=",NameBegin1='".addslashes($namebegin1)."'";
		$q.=",NameDomainID1=".$namedomainid1;
		$q.=",Target='".addslashes($target)."'";
		$q.=",Descr='".addslashes($descr)."'";
		if($cnameid!=0){
			$q.=" where ID=".$cnameid;
		}
		$q.=";";
		db_q($q,$sock,$FUNC.": inserting/updating");
		if($cnameid==0){
			$cnameid=db_insert_id($sock);
		}
		dblog_Append($sock,DBLOG_WEIGHT_NORMAL,$user,$FUNC,"ID=".$cnameid.",NameBegin1='".addslashes($namebegin1)."',NameDomainID1=".$namedomainid1.",Target='".addslashes($target)."'");
		$cname=ReadCname($sock,$cnameid);
		return($cname);
	}
//----------------------------------------------------------
	function DeleteCname($sock,$cnameid){
		$FUNC="DeleteCname";
		$q="delete from cnames where ID=".$cnameid.";";
		db_q($q,$sock,$FUNC.": removing");
	}
?>
