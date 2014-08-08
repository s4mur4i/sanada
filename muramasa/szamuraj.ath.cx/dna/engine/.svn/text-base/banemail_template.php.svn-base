<?
	// INPUT: banlog structure named $entry
?>
<TABLE border=1 cellspacing=0 cellpadding=3>
<TR>
<TH align='right'>Dátum:</TH>
<TD><?=StampToDateTime($entry->CreateD)?></TD>
</TR>
<TR>
<TH align='right'>Esemény:</TH>
<TD><?
	switch($entry->EventType){
		case BANLOG_EVENTTYPE_BAN: echo("Letiltás"); break;
		case BANLOG_EVENTTYPE_UNBAN: echo("Letiltás feloldása"); break;
		case BANLOG_EVENTTYPE_LIMIT: echo("Korlátozás"); break;
		case BANLOG_EVENTTYPE_UNLIMIT: echo("Korlátozás feloldása"); break;
		default: echo("ERROR"); break;
	}
?></TD>
</TR>
<TR>
<TH align='right'>Felhasználó:</TH>
<TD>(<?=$entry->UserID?>: <?=$entry->UserNick?>) <?=ToHTML($entry->UserName)?></TD>
</TR>
<TR>
<TH align='right'>Gép, rendszergazda:</TH>
<TD>(<?=$entry->ComputerIP?>) <?=ToHTML($entry->ComputerName)?>, <?=ToHTML($entry->ComputerRealName)?></TD>
</TR>
<TR>
<TH align='right'>Kitiltás/Korlátozás vége:</TH>
<TD><?=StampToDateTime($entry->BanEndD)?></TD>
</TR>
<TR>
<TH align='right'>Indoklás:</TH>
<TD><?=nl2br(ToHTML($entry->Comment))?></TD>
</TR>
</TABLE>
