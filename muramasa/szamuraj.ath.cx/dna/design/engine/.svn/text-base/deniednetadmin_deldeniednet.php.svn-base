<H1>Tiltott hálózat törlése</H1>
<? require_once("design/engine/default_result.php"); ?>
<H2><?=ToHTML($deniednet->Network)?>/<?=$deniednet->MaskLength?></H2>
Megjegyzés: <?=nl2br(ToHTML($deniednet->Descr))?><BR>
<BR>
<B>Biztosan törölni akarod ezt a tiltott hálózatot?</B><BR>
<BR>
<TABLE width=200 border=0 cellspacing=0 cellpadding=3><TR align='center'>
<FORM action='index.php' method='POST'>
<INPUT type=HIDDEN name='mode' value='deniednetadmin'>
<INPUT type=HIDDEN name='func' value='trydeldeniednet'>
<INPUT type=HIDDEN name='id' value='<?=$deniednet->ID?>'>
<TD width='50%'><INPUT type=SUBMIT name='ok' value='Igen'></TD>
</FORM>
<FORM action='index.php' method='GET'>
<INPUT type=HIDDEN name='mode' value='deniednetadmin'>
<INPUT type=HIDDEN name='func' value='deniednets'>
<TD width='50%'><INPUT type=SUBMIT name='ok' value='Nem'></TD>
</FORM>
</TABLE>
<BR>
