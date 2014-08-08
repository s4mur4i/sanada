<? if($func=="bancomputer"){ ?><H1>Számítógép időleges kitiltása</H1><? } ?>
<? if($func=="limitcomputer"){ ?><H1>Számítógép időleges korlátozása</H1><? } ?>
<? require_once("design/engine/default_result.php"); ?>
<H2><?=ToHTML($computer->Name)?> (<?=ToHTML($computer->IP)?>)</H2>
Rendszergazdája: <?=ToHTML($root->RealName)?> &lt;<?=ToHTML($root->Email)?>&gt;<BR>
<BR>
<FORM action='index.php' method='POST'>
<INPUT type=HIDDEN name='mode' value='computeradmin'>
<INPUT type=HIDDEN name='func' value='try<?=$func?>'>
<INPUT type=HIDDEN name='computerid' value='<?=$computer->ID?>'>
<? if($func=="bancomputer"){ ?>
Eddig: <INPUT type=TEXT name='banneduntild' value='<?=StampToDateTime($banneduntild)?>'><BR>
<? } ?>
<? if($func=="limitcomputer"){ ?>
Eddig: <INPUT type=TEXT name='limiteduntild' value='<?=StampToDateTime($limiteduntild)?>'><BR>
<? } ?>
Indoklás:<BR>
<TEXTAREA cols=80 rows=5 wrap=virtual name='comment'><?=ToHTML($comment)?></TEXTAREA><BR>
<BR>
<? if($func=="bancomputer"){ ?><B>Biztosan ki akarod tiltani ezt a számítógépet?</B><BR><? } ?>
<? if($func=="limitcomputer"){ ?><B>Biztosan korlátozni akarod tiltani ezt a számítógépet?</B><BR><? } ?>
<BR>
<TABLE width=200 border=0 cellspacing=0 cellpadding=3><TR align='center'>
<TD width='50%'><INPUT type=SUBMIT name='ok' value='Igen'></TD>
</FORM>
<FORM action='index.php' method='GET'>
<INPUT type=HIDDEN name='mode' value='search'>
<INPUT type=HIDDEN name='func' value='search'>
<TD width='50%'><INPUT type=SUBMIT name='ok' value='Nem'></TD>
</FORM>
</TABLE>
<BR>
