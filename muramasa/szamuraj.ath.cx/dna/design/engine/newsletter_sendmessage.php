<H1>Hírlevél küldés</H1>
<? require_once("design/engine/default_result.php"); ?>
<TABLE cellpadding=2 cellspacing=3>
<TR><FORM method=post action=index.php>
<INPUT type=hidden name='mode' value='newsletter'>
<INPUT type=hidden name='func' value='trysendmessage'>
<TR><TH align='right'>From:</TD><TD class='data'><?=CFG_SYSTEM_SENDERNAME?> <?=CONFIG_NEWSLETTER_FROM?></TD></TR>
<TR><TH align='right'>Reply-To:</TD><TD class='data'><?=CONFIG_NEWSLETTER_REPLYTO?></TD></TR>
<TR><TH align='right'>To:</TD><TD class='data'><SELECT name=domainid>
<OPTION value=0>Minden</OPTION>
<?
	foreach($domains as $row){
		if(isset($domainid) && $domainid==$row->ID)
			$sel=" SELECTED";
		else
			$sel="";
		echo("<OPTION value='".$row->ID."'".$sel.">");
		if($row->DomainType==DOMAINTYPE_FORWARD)
			echo("Normál: ".$row->NameEnd);
		if($row->DomainType==DOMAINTYPE_REVERSE)
			echo("Fordított: ".$row->IPBegin);
		echo("</OPTION>\n");
	}
?>
</SELECT> domain rendszergazdái</TD></TR>
<TR><TH align='right'>Subject:</TD><TD class='data' valign=middle>[CSOMANET-HIRLEVEL] <INPUT type=text name=subject size=30 value='<?=$subject?>'></TD></TR>
<TR><TH align='right' valign=top>Body:</TD>
<TD class='data'><TT>
Kedves * *, számítógép üzemeltető!<BR>
<TEXTAREA name=body cols=60 rows=10></TEXTAREA><BR>
KCSSK Halozati Adminisztratorok<BR>
------------------------------------------------------------<BR>
Ez egy KCSSK CSOMANET hírlevél. Tartalma illetve a benne lévő<BR>
esetleges felszólítások nem minden esetben vonazkoznak rád.<BR>
</TT></TD></TR>
<TR><TD colspan=2 align='center'>
<BR>
<TABLE width=200 border=0 cellspacing=0 cellpadding=3><TR align='center'>
<TD width='50%'><INPUT type=SUBMIT name='ok' value='Küldés'></TD>
</FORM>
<FORM action='index.php' method='GET'>
<INPUT type=HIDDEN name='mode' value='home'>
<TD width='50%'><INPUT type=SUBMIT name='ok' value='Mégsem'></TD>
</FORM>
</TR></TABLE>
<BR>
</TD></TR>
</TABLE>
