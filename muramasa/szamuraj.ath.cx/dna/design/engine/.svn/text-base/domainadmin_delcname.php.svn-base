<H1>CNAME törlése</H1>
<? require_once("design/engine/default_result.php"); ?>
<H2><?=ToHTML($cname->NameBegin1." (".$cname->NameEnd1.")")?> CNAME <?=ToHTML($cname->Target)?></H2>
<BR>
<B>Biztosan törölni akarod ezt a CNAME-et?</B><BR>
<BR>
<TABLE width=200 border=0 cellspacing=0 cellpadding=3><TR align='center'>
<FORM action='index.php' method='POST'>
<INPUT type=HIDDEN name='mode' value='domainadmin'>
<INPUT type=HIDDEN name='func' value='trydelcname'>
<INPUT type=HIDDEN name='cnameid' value='<?=$cname->ID?>'>
<TD width='50%'><INPUT type=SUBMIT name='ok' value='Igen'></TD>
</FORM>
<FORM action='index.php' method='GET'>
<INPUT type=HIDDEN name='mode' value='domainadmin'>
<INPUT type=HIDDEN name='func' value='domains'>
<TD width='50%'><INPUT type=SUBMIT name='ok' value='Nem'></TD>
</FORM>
</TABLE>
<BR>
