<H1>Hírlevél küldés</H1>
<TABLE border=1 cellspacing=0 cellpadding=3><TR><TD>
Keresett: '<?=ToHTML($search)?>'<BR>
<? if($ban==0){ ?>Nem tiltott gépek<BR><? } ?>
<? if($ban==1){ ?>Tiltott gépek<BR><? } ?>
<? if($validitystate!=-1){ ?>Fizetettség: <?=$d_validitystates[$validitystate]?> [<?=ToHTML($reftime)?>]<BR><? } ?>
<? if($accessclass!=-1){ ?>Elérés típusa: <?=$d_accessclasses[$accessclass]?><BR><? } ?>
<BR>
Találatok száma: <?=count($computers)?><BR>
Rendszergazdák száma: <?=count($roots)?><BR>
</TD></TR></TABLE>
<BR>
<? require_once("design/engine/default_result.php"); ?>
<TABLE cellpadding=2 cellspacing=3>
<TR><FORM method=post action=index.php>
<INPUT type=hidden name='mode' value='search'>
<INPUT type=hidden name='func' value='trysearch_mail'>
<TR><TH align='right'>From:</TD><TD class='data'><?=CFG_SYSTEM_SENDERNAME?> <?=CONFIG_NEWSLETTER_FROM?></TD></TR>
<TR><TH align='right'>Reply-To:</TD><TD class='data'><?=CONFIG_NEWSLETTER_REPLYTO?></TD></TR>
<TR><TH align='right'>Subject:</TD><TD class='data' valign=middle>[CSOMANET-ERTESITO] <INPUT type=text name='subject' size=30 value='<?=$subject?>'></TD></TR>
<TR><TH align='right' valign=top>Body:</TD>
<TD class='data'><TT>
Kedves * *, számítógép üzemeltető!<BR>
<TEXTAREA name=body cols=60 rows=10></TEXTAREA><BR>
KCSSK Halozati Adminisztratorok<BR>
------------------------------------------------------------<BR>
Ez egy KCSSK CSOMANET hírlevél. Tartalma illetve a benne lévő<BR>
esetleges felszólítások nem minden esetben vonazkoznak rád.<BR>
</TT></TD></TR>
<TR><TD colspan=2 align='center'>
<BR>
<TABLE width=200 border=0 cellspacing=0 cellpadding=3><TR align='center'>
<TD width='50%'><INPUT type=SUBMIT name='ok' value='Küldés'></TD>
</FORM>
<FORM action='index.php' method='GET'>
<INPUT type=HIDDEN name='mode' value='search'>
<INPUT type=HIDDEN name='func' value='search'>
<TD width='50%'><INPUT type=SUBMIT name='ok' value='Mégsem'></TD>
</FORM>
</TR></TABLE>
<BR>
</TD></TR>
</TABLE>
