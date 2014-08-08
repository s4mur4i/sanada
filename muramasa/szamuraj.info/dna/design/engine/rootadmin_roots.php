<? if($func=="roots"){ ?>
<H1>Rendszergazdák és számítógép üzemeltetők</H1>
<? require_once("design/engine/default_result.php"); ?>
<? } ?>
<TABLE border=1 cellspacing=0 cellpadding=3>
<TR>
<TH>Név</TH>
<TH>E-mail</TH>
<TH>EHA-kód</TH>
<TH>Szoba</TH>
<TH>Gépek</TH>
</TR>
<?
	for($i=0;$i<count($roots);$i++){
		$root=$roots[$i];
		$anchor="<A name='root_".$root->ID."'></A>";
		if(HasRights("COMPUTERADMIN",$user)==1){
			$a1="<A href='index.php?mode=rootadmin&func=modifyroot&rootid=".$root->ID."'>";
			$a2="</A>";
		} else {
			$a1="";
			$a2="";
		}
?>
<TR valign='top'>
<TD><?=$anchor?><?=$a1?><?=ToHTML($root->RealName)?><?=$a2?></TD>
<TD><?=ToHTML($root->Email)?></TD>
<TD><?=ToHTML($root->PersonalID)?></TD>
<TD><?=ToHTML($root->Building."/".$root->Room)?></TD>
<TD><?=$root->ComputerCount?> <? if($root->ComputerCount==0){ ?><FONT class='danger'>!!!</FONT><? } ?></TD>
</TR>
<?
	}
?>
</TABLE>
<BR>
Összesen <?=count($roots)?> rendszergazda és számítógép üzemeltető<BR>
<BR>
