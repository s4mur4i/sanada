<? if($func=="newdeniednet"){ ?>
<H1>Új tiltott hálózatok</H1>
<? } else { ?>
<H1>Tiltott hálózat módosítása</H1>
<? } ?>
<? require_once("design/engine/default_result.php"); ?>
<TABLE cellpadding=2 cellspacing=3>
<FORM method=POST action='index.php'>
<INPUT type=hidden name='mode' value='deniednetadmin'>
<INPUT type=hidden name='func' value='try<?=$func?>'>
<? if($func=="modifydeniednet"){ ?>
<INPUT type=hidden name='id' value='<?=$deniednet->ID?>'>
<? } ?>
<TR><TH align='right'>Hálózat címe:</TH><TD class='data'><INPUT type=TEXT name='network' value='<?=ToHTML($network)?>'></TD></TR>
<TR><TH align='right'>Netmaszk szélessége:</TH><TD class='data'><INPUT type=TEXT name='masklength' value='<?=$masklength?>'></TD></TR>
<TR><TH align='right'>Leírás:</TH><TD class='data'><INPUT type=TEXT name='descr' value='<?=ToHTML($descr)?>'></TD></TR>
<TR align='center'><TD colspan=2>
<BR>
<TABLE border=0 cellspacing=0 cellpadding=3><TR align='center'>
<TD width='50%'><INPUT type=SUBMIT name='ok' value='OK'></TD>
</FORM>
<FORM action='index.php' method='GET'>
<INPUT type=hidden name='mode' value='deniednetadmin'>
<INPUT type=hidden name='func' value='deniednets'>
<TD width='50%'><INPUT type=SUBMIT name='ok' value='Mégsem'></TD>
</FORM>
</TR></TABLE>
</TD></TR>
</TABLE>
