<?
	require_once("engine/domains_common.php");
//----------------------------------------------------------
	function RegisterDomainExport($sock,$domainid,$soaserial){
		$FUNC="RegisterDomainExport";
		$q="update domains set LastExportD=".TIME.",SOASerial=".$soaserial." where ID=".$domainid.";";
		db_q($q,$sock,$FUNC.": updating");
	}
?>
