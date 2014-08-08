<?
	require_once("engine/roots_common.php");
//----------------------------------------------------------
	function ReadRootByEmail($sock,$email){
		$FUNC="ReadRootByEmail";
		$q="select * from roots where Email='".addslashes($email)."';";
		$res=db_q($q,$sock,$FUNC.": selecting");
		if(db_num_rows($res)==1) $root=db_fetch_object($res);
		else $root="";
		db_free_result($res);
		return($root);
	}
//----------------------------------------------------------
	function ReadRootByPersonalID($sock,$personalid){
		$FUNC="ReadRootByPersonalID";
		$q="select * from roots where PersonalID='".addslashes($personalid)."';";
		$res=db_q($q,$sock,$FUNC.": selecting");
		if(db_num_rows($res)==1) $root=db_fetch_object($res);
		else $root="";
		db_free_result($res);
		return($root);
	}
//----------------------------------------------------------
	function CheckPersonalID($sock,$rootid,$personalid){
		$result="";
		if($personalid=="" || $personalid=="0"){
			$result.="Nincs megadva az EHA-kód!".BR;
		} elseif(preg_match("/".CFG_PERSONALID_PATTERN."/",$personalid)==0){
			$result.="Érvénytelen EHA kód formátum. Helyes (regexp) formátum: \"".ToHTML(addslashes(CFG_PERSONALID_PATTERN))."\"";
		} else {
			$root=ReadRootByPersonalID($sock,$personalid);
			if(is_object($root) && $rootid!=$root->ID){
				$result.="Ilyen EHA kód már szerepel az adatbázisban: ".ToHTML($root->RealName." <".$root->Email.">").BR;
			}
		}
		return $result;
	}
//----------------------------------------------------------
	function CreateRoot($sock,$user,$realname,$building,$room,$email,$personalid){
		$FUNC="CreateRoot";
		$q="insert into roots set";
		$q.=" RealName='".addslashes($realname)."'";
		$q.=",Building='".addslashes($building)."'";
		$q.=",Room='".addslashes($room)."'";
		$q.=",Email='".addslashes($email)."'";
		$q.=",PersonalID='".addslashes($personalid)."'";
		$q.=";";
		db_q($q,$sock,$FUNC.": inerting");
		$id=db_insert_id($sock,"roots");
		$root=ReadRoot($sock,$id);
		dblog_Append($sock,DBLOG_WEIGHT_NORMAL,$user,$FUNC,"ID=".$root->ID.",Email='".addslashes($email)."',RealName='".addslashes($realname)."'");
		return($root);
	}
//----------------------------------------------------------
	function ModifyRoot($sock,$user,$id,$realname,$building,$room,$email,$personalid){
		$FUNC="ModifyRoot";
		$q="update roots set";
		$q.=" RealName='".addslashes($realname)."'";
		$q.=",Building='".addslashes($building)."'";
		$q.=",Room='".addslashes($room)."'";
		$q.=",Email='".addslashes($email)."'";
		$q.=",PersonalID='".addslashes($personalid)."'";
		$q.=" where ID=".$id.";";
		$q.=";";
		db_q($q,$sock,$FUNC.": updating");
		dblog_Append($sock,DBLOG_WEIGHT_NORMAL,$user,$FUNC,"ID=".$id.",Email='".addslashes($email)."',RealName='".addslashes($realname)."'");
		$root=ReadRoot($sock,$id);
		return($root);
	}
//----------------------------------------------------------
	function DeleteRoot($sock,$user,$root){
		$FUNC="DeleteRoot";
		$q="delete from roots where ID=".$root->ID.";";
		db_q($q,$sock,$FUNC.": removing");
		dblog_Append($sock,DBLOG_WEIGHT_NORMAL,$user,$FUNC,"ID=".$root->ID.",Email='".addslashes($root->Email)."',RealName='".addslashes($root->RealName)."'");
	}
?>
