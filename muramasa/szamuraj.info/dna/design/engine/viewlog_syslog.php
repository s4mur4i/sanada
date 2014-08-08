<H1>Rendszer napló</H1>
<? require_once("design/engine/default_result.php"); ?>
<TABLE border=0 cellspacing=0 cellpadding=10 align='center'><TR valign='center'>
<TD align='left' width='20%' nowrap style='white-space: nowrap'><A href='index.php?mode=viewlog&func=syslog&t1=<?=($t1-($t2-$t1))?>&t2=<?=$t1?>'>&lt;&lt;&lt; Előző oldal</TD>
<TD align='center' width='60%'><H2 style='margin: 0px'><TT><?=StampToDateTime($t1)?> -&gt; <?=StampToDateTime($t2)?></TT></H2>(<?=count($dblog)?> bejegyzés)</TD>
<TD align='right' width='20%' nowrap style='white-space: nowrap'><A href='index.php?mode=viewlog&func=syslog&t1=<?=$t2?>&t2=<?=($t2+($t2-$t1))?>'>Következő oldal &gt;&gt;&gt;</TD>
</TR></TABLE>
<BR>
<?
	if(count($dblog)>0){
?>
<TABLE border=1 cellspacing=0 cellpadding=3>
<TR>
<TH width=1>Dátum</TH>
<TH width=1>Felhasználó</TH>
<TH width=1>Akció</TH>
<TH>Paraméterek</TH>
</TR>
<?
	for($i=0;$i<count($dblog);$i++){
		$entry=$dblog[$i];
?>
<? if($entry->Weight==DBLOG_WEIGHT_WARNING){ ?>
<TR valign='top' class='danger'>
<? } else { ?>
<TR valign='top'>
<? } ?>
<TD nowrap style='white-space: nowrap'><?=StampToDateTime($entry->EventD)?></TD>
<TD nowrap style='white-space: nowrap'>(<?=$entry->UserID?>) <?=$entry->UserNick?></TD>
<TD nowrap style='white-space: nowrap'><?=ToHTML($entry->Event)?></TD>
<TD><?=ToHTML($entry->Params)?></TD>
</TR>
<?
	}
?>
</TABLE>
<?
	} else echo("Nincsen bejegyzés.<BR>\n");
?>
<BR>
