<H1>Letiltás napló</H1>
<? require_once("design/engine/default_result.php"); ?>
<H2><TT><?=StampToDateTime($t1)?> -&gt; <?=StampToDateTime($t2)?></TT></H2>
<I>A napló nem tartalmazza a tiltások automatikus feloldását.</I><BR>
<BR>
<?
	if(count($banlog)>0){
?>
<TABLE border=1 cellspacing=0 cellpadding=3>
<TR>
<TH width=1>Dátum</TH>
<TH width=1>Esemény</TH>
<TH>Felhasználó</TH>
<TH width=1>Gép, rendszergazda</TH>
<TH width=1>Kitiltás vége</TH>
</TR>
<TR>
<TH colspan=5>Indoklás</TH>
</TR>
<?
	for($i=0;$i<count($banlog);$i++){
		$entry=$banlog[$i];
?>
<TR valign='top'>
<TD><?=StampToDateTime($entry->CreateD)?></TD>
<TD><?
	switch($entry->EventType){
		case BANLOG_EVENTTYPE_BAN: echo("<SPAN class='danger'>Letiltás</SPAN>"); break;
		case BANLOG_EVENTTYPE_UNBAN: echo("<SPAN class='good'>Letiltás&nbsp;feloldása</SPAN>"); break;
		case BANLOG_EVENTTYPE_LIMIT: echo("<SPAN class='danger'>Korlátozás</SPAN>"); break;
		case BANLOG_EVENTTYPE_UNLIMIT: echo("<SPAN class='good'>Korlátozás&nbsp;feloldása</SPAN>"); break;
		default: echo("<FONT class='result'>ERROR</FONT>"); break;
	}
?></TD>
<TD nowrap style='white-space: nowrap'>(<?=$entry->UserID?>: <?=$entry->UserNick?>) <?=ToHTML($entry->UserName)?></TD>
<TD>(<?=$entry->ComputerIP?>) <?=ToHTML($entry->ComputerName)?>,<BR><?=ToHTML($entry->ComputerRealName)?></TD>
<TD><?=StampToDateTime($entry->BanEndD)?></TD>
</TR>
<TR>
<TD colspan=5><?=nl2br(ToHTML($entry->Comment))?></TD>
</TR>
<?
	}
?>
</TABLE>
<?
	} else echo("Nincsen bejegyzés.<BR>\n");
?>
<BR>
