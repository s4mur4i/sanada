<H1>Domain törlése</H1>
<? require_once("design/engine/default_result.php"); ?>
<? if($domain->DomainType==DOMAINTYPE_FORWARD){ ?>
<h2>Normál: <?=ToHTML($domain->NameEnd)?></h2>
<? } else { ?>
<h2>Fordított: <?=ToHTML($domain->IPBegin)?></h2>
<? } ?>
<BR>
<B>Biztosan törölni akarod ezt a domain-t?</B><BR>
<BR>
<TABLE width=200 border=0 cellspacing=0 cellpadding=3><TR align='center'>
<FORM action='index.php' method='POST'>
<INPUT type=HIDDEN name='mode' value='domainadmin'>
<INPUT type=HIDDEN name='func' value='try<?=$func?>'>
<INPUT type=HIDDEN name='domainid' value='<?=$domain->ID?>'>
<TD width='50%'><INPUT type=SUBMIT name='ok' value='Igen'></TD>
</FORM>
<FORM action='index.php' method='GET'>
<INPUT type=HIDDEN name='mode' value='domainadmin'>
<INPUT type=HIDDEN name='func' value='domains'>
<TD width='50%'><INPUT type=SUBMIT name='ok' value='Nem'></TD>
</FORM>
</TABLE>
<BR>
