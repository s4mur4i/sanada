<H1>Beállítás módosítása</H1>
<H2>"<?=ToHTML(addslashes($variable->Name))?>"</H2>
<P class='large'><?=ToHTML($variable->Descr)?></P>
<? require_once("design/engine/default_result.php"); ?>
<TABLE cellpadding=2 cellspacing=3>
<TR><FORM method='post' action='index.php'>
<INPUT type=hidden name='mode' value='variables'>
<INPUT type=hidden name='func' value='try<?=$func?>'>
<INPUT type=HIDDEN name='name' value='<?=ToHTML($variable->Name)?>'>
<TR><TH align='right'>Régi érték:</TD><TD class='data'><SPAN class='lined'><?=ToHTML($variable->Value)?></SPAN></TD></TR>
<TR><TH align='right'>Új érték:</TD><TD class='data'><INPUT style='font-family: monospace;' type=TEXT name='value' value='<?=ToHTML($value)?>'></TD></TR>
<TR><TD colspan=2 align='center'>
<TABLE width=200 border=0 cellspacing=0 cellpadding=3><TR align='center'>
<TD width='50%'><INPUT type=SUBMIT name='ok' value='OK'></TD>
</FORM>
<FORM action='index.php' method='GET'>
<INPUT type=HIDDEN name='mode' value='variables'>
<INPUT type=HIDDEN name='func' value='list'>
<TD width='50%'><INPUT type=SUBMIT name='ok' value='Mégsem'></TD>
</FORM>
</TR></TABLE>
<BR>
</TABLE>
