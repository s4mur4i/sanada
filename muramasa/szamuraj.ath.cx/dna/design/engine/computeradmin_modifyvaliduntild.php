<H1>Számítógép érvényességének módosítása</H1>
<H2><?=ToHTML($computer->Name)?> (<?=ToHTML($computer->IP)?>)</H2>
Rendszergazdája: <?=ToHTML($root->RealName)?> &lt;<?=ToHTML($root->Email)?>&gt;<BR>
Érvényes: <?=$computer->ValidUntilD==0?"<SPAN class='good'>Örökké</SPAN>":d_ColoredStampToDateTime($computer->ValidUntilD)?><BR>
<BR>
<? if($computer->ValidUntilD!=0 && $computer->ValidUntilD<NEXT_GRACE_STAMP){ ?>
<H2>Haladék adása</H2>
<TABLE cellpadding=2 cellspacing=3>
<FORM method=POST action='index.php'>
<INPUT type=hidden name='mode' value='computeradmin'>
<INPUT type=hidden name='func' value='try<?=$func?>'>
<INPUT type=HIDDEN name='computerid' value='<?=ToHTML($computer->ID)?>'>
<INPUT type=hidden name='validuntil_type' value='2'>
<INPUT type=hidden name='validuntil_date' value='<?=StampToDateTime(NEXT_GRACE_STAMP)?>'>
<TR><TH align='right'>Haladék adása:</TD><TD class='data'><?=d_ColoredStampToDateTime(NEXT_GRACE_STAMP)?> <INPUT type=SUBMIT name='ok' value='OK'></TD></TR>
</FORM>
</TABLE>
<BR>
<? } ?>
<? if($computer->ValidUntilD!=0 && $computer->ValidUntilD<NEXT_TERMINATION_STAMP){ ?>
<H2>Következő érvényességi szakasz megadása</H2>
<TABLE cellpadding=2 cellspacing=3>
<FORM method=POST action='index.php'>
<INPUT type=hidden name='mode' value='computeradmin'>
<INPUT type=hidden name='func' value='try<?=$func?>'>
<INPUT type=HIDDEN name='computerid' value='<?=ToHTML($computer->ID)?>'>
<INPUT type=hidden name='validuntil_type' value='2'>
<INPUT type=hidden name='validuntil_date' value='<?=StampToDateTime(NEXT_TERMINATION_STAMP)?>'>
<TR><TH align='right'>Következő érvényességi szakasz megadása:</TD><TD class='data'><?=d_ColoredStampToDateTime(NEXT_TERMINATION_STAMP)?> <INPUT type=SUBMIT name='ok' value='OK'></TD></TR>
</FORM>
</TABLE>
<BR>
<? } ?>
<H2>Módosítás</H2>
<? require_once("design/engine/default_result.php"); ?>
<TABLE cellpadding=2 cellspacing=3>
<FORM method='post' action='index.php'>
<INPUT type=hidden name='mode' value='computeradmin'>
<INPUT type=hidden name='func' value='try<?=$func?>'>
<INPUT type=HIDDEN name='computerid' value='<?=ToHTML($computer->ID)?>'>
<TR><TH align='right'>Érvényesség:</TH><TD class='data'>
<INPUT type='RADIO' name='validuntil_type' value=2<?=$validuntil_type==2?" CHECKED":""?>> Egyedi <INPUT type=TEXT name='validuntil_date' value='<?=ToHTML($validuntil_date)?>'><BR>
<INPUT type='RADIO' name='validuntil_type' value=3<?=$validuntil_type==3?" CHECKED":""?>> Örökre<BR>
</TD></TR>
<TR><TD colspan=2 align='center'>
<TABLE width=200 border=0 cellspacing=0 cellpadding=3><TR align='center'>
<TD width='50%'><INPUT type=SUBMIT name='ok' value='OK'></TD>
</FORM>
<FORM action='index.php' method='GET'>
<INPUT type=HIDDEN name='mode' value='computeradmin'>
<INPUT type=HIDDEN name='func' value='modifycomputer'>
<INPUT type=HIDDEN name='computerid' value='<?=ToHTML($computer->ID)?>'>
<TD width='50%'><INPUT type=SUBMIT name='ok' value='Mégsem'></TD>
</FORM>
</TR></TABLE>
<BR>
</TABLE>
