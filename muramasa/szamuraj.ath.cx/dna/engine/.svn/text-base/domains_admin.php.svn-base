<?
	require_once("engine/domains_common.php");
	require_once("engine/cnames_common.php");
//----------------------------------------------------------
	function UpdateDomain($sock,$user,$domainid,$domaintype,$ipbegin,$nameend,$ttl,$soaserver,$soaemail,$soarefresh,$soaretry,$soaexpire,$soanegttl,$text,$clientconfig){
		if($domainid==0){
			$FUNC="CreateDomain";
			$q="insert into domains set ";
			$q.="DomainType='".addslashes($domaintype."")."',";
			$q.="IPBegin='".addslashes($ipbegin."")."',";
			$q.="NameEnd='".addslashes($nameend."")."',";
		} else {
			$FUNC="ModifyDomain";
			$q="update domains set ";
		}
		$q.="TTL=".addslashes($ttl+0).",";
		$q.="SOAServer='".addslashes($soaserver."")."',";
		$q.="SOAEmail='".addslashes($soaemail."")."',";
		$q.="SOARefresh='".addslashes($soarefresh+0)."',";
		$q.="SOARetry='".addslashes($soaretry+0)."',";
		$q.="SOAExpire='".addslashes($soaexpire+0)."',";
		$q.="SOANegTTL='".addslashes($soanegttl+0)."',";
		$q.="Text='".addslashes($text)."',";
		$q.="ClientConfig='".addslashes($clientconfig)."',";
		$q.="ModifyD=".TIME;
		if($domainid!=0)
			$q.=" where ID=".$domainid.";";
		db_q($q,$sock,__FUNCTION__.($domainid==0?": creating":": modifying"));
		dblog_Append($sock,DBLOG_WEIGHT_NORMAL,$user,$FUNC,"ID=".$domainid.",IPBegin='".$ipbegin."',NameEnd='".addslashes($nameend)."'");
	}
//----------------------------------------------------------
	function DeleteDomain($sock,$domainid)
	{
		$q="delete from domains where ID=".$domainid.";";
		db_q($q,$sock,__FUNCTION__.": removing");
	}
?>
