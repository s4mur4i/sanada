<H1>Rendszer beállítások</H1>
<? require_once("design/engine/default_result.php"); ?>
<TABLE border=1 cellspacing=0 cellpadding=3>
<TR>
<TH>Név / Leírás</TH>
<TH>Érték</TH>
</TR>
<?
	$_power=HasRights("USERADMIN");
	for($i=0;$i<count($variables);$i++){
		$v=$variables[$i];
		if($_power==1){
			$a1="<A href='index.php?mode=variables&func=modify&name=".ToHTML($v->Name)."'>";
			$a2="</A>";
		} else {
			$a1="";
			$a2="";
		}
?>
<TR valign='top'>
<TD><?=$a1?><STRONG><?=ToHTML($v->Name)?></STRONG><?=$a2?><BR><?=ToHTML($v->Descr)?></TD>
<TD><SPAN class='lined'><?=ToHTML($v->Value)?></SPAN></TD>
</TR>
<? } ?>
</TABLE>
