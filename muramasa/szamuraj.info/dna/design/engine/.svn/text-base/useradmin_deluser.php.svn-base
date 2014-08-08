<H1>Felhasználó törlése</H1>
<? require_once("design/engine/default_result.php"); ?>
<H2>#<?=$luser->ID?> (<?=ToHTML($luser->Nick)?>) <?=ToHTML($luser->RealName)?></H2>
<BR>
<B>Biztosan törölni akarod ezt a felhasználót?</B><BR>
<BR>
<TABLE width=200 border=0 cellspacing=0 cellpadding=3><TR align='center'>
<FORM action='index.php' method='POST'>
<INPUT type=HIDDEN name='mode' value='useradmin'>
<INPUT type=HIDDEN name='func' value='trydeluser'>
<INPUT type=HIDDEN name='luserid' value='<?=$luser->ID?>'>
<TD width='50%'><INPUT type=SUBMIT name='ok' value='Igen'></TD>
</FORM>
<FORM action='index.php' method='GET'>
<INPUT type=HIDDEN name='mode' value='useradmin'>
<INPUT type=HIDDEN name='func' value='users'>
<TD width='50%'><INPUT type=SUBMIT name='ok' value='Nem'></TD>
</FORM>
</TABLE>
<BR>
