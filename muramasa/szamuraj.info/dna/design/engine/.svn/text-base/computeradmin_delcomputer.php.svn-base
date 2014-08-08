<H1>Számítógép törlése</H1>
<? require_once("design/engine/default_result.php"); ?>
<H2><?=ToHTML($computer->Name)?> (<?=ToHTML($computer->IP)?>)</H2>
Rendszergazdája: <?=ToHTML($root->RealName)?> &lt;<?=ToHTML($root->Email)?>&gt;<BR>
<BR>
<B>Biztosan törölni akarod ezt a számítógépet?</B><BR>
<BR>
<TABLE width=200 border=0 cellspacing=0 cellpadding=3><TR align='center'>
<FORM action='index.php' method='POST'>
<INPUT type=HIDDEN name='mode' value='computeradmin'>
<INPUT type=HIDDEN name='func' value='trydelcomputer'>
<INPUT type=HIDDEN name='computerid' value='<?=$computer->ID?>'>
<TD width='50%'><INPUT type=SUBMIT name='ok' value='Igen'></TD>
</FORM>
<FORM action='index.php' method='GET'>
<INPUT type=HIDDEN name='mode' value='search'>
<INPUT type=HIDDEN name='func' value='search'>
<TD width='50%'><INPUT type=SUBMIT name='ok' value='Nem'></TD>
</FORM>
</TABLE>
<BR>
