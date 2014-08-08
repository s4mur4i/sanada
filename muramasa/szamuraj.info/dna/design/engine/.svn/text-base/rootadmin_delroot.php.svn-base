<H1>Rendszergazda törlése</H1>
<? require_once("design/engine/default_result.php"); ?>
<H2><?=ToHTML($root->RealName)?> (<?=ToHTML($root->Building."/".$root->Room)?>)</H2>
<BR>
<B>Biztosan törölni akarod ezt a rendszergazdát?</B><BR>
<BR>
<TABLE width=200 border=0 cellspacing=0 cellpadding=3><TR align='center'>
<FORM action='index.php' method='POST'>
<INPUT type=HIDDEN name='mode' value='rootadmin'>
<INPUT type=HIDDEN name='func' value='trydelroot'>
<INPUT type=HIDDEN name='rootid' value='<?=$root->ID?>'>
<TD width='50%'><INPUT type=SUBMIT name='ok' value='Igen'></TD>
</FORM>
<FORM action='index.php' method='GET'>
<INPUT type=HIDDEN name='mode' value='rootadmin'>
<INPUT type=HIDDEN name='func' value='roots'>
<TD width='50%'><INPUT type=SUBMIT name='ok' value='Nem'></TD>
</FORM>
</TABLE>
<BR>
