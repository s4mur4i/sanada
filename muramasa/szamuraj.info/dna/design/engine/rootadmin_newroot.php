<? if($func=="modifyroot"){ ?>
<H1>Rendszergazda módosítása</H1>
<? } else { ?>
<H1>Új rendszergazda</H1>
<FONT class='small'>(külön minek?)</FONT><BR>
<? } ?>
<? require_once("design/engine/default_result.php"); ?>
<TABLE cellpadding=2 cellspacing=3>
<FORM method=post action=index.php>
<INPUT type=hidden name='mode' value='rootadmin'>
<INPUT type=hidden name='func' value='try<?=$func?>'>
<? if($func=="modifyroot"){ ?>
<INPUT type=hidden name=rootid value='<?=$root->ID?>'>
<? } ?>
<TR><TH align=right>EHA-kód:</TH><TD class='data'><INPUT type=text name=personalid size=12 maxlength=16 value='<?=ToHTML($personalid)?>'></TD></TR>
<TR><TH align=right>Neve:</TH><TD class='data'><INPUT type=text name=realname size=30 maxlength=64 value='<?=ToHTML($realname)?>'></TD></TR>
<TR><TH align=right>Szoba:</TH><TD class='data' valign=middle><INPUT type=TEXT size=2 maxsize=1 name='rootbuilding' value='<?=ToHTML($rootbuilding)?>'> <INPUT type=TEXT name='rootroom' size=17 maxsize=16 value='<?=ToHTML($rootroom)?>'></TD></TR>
<TR><TH align=right>Email:</TH><TD class='data'><INPUT type=text name=email size=30 maxlength=128 value='<?=ToHTML($email)?>'></TD></TR>
<TR><TH align=right>Gépek:</TH><TD class='data'><?=$root->ComputerCount?> gépen rendszergazda
<? if($root->ComputerCount>0){ ?> <A href='index.php?mode=search&func=search&search=<?=ToURL($root->Email)?>'>&gt;&gt;&gt;</A><? } ?>
</TD></TR>
<TR><TD colspan=2 align='center'>
<BR>
<TABLE width=200 border=0 cellspacing=0 cellpadding=3><TR align='center'>
<TD width=50%><INPUT type=SUBMIT name='ok' value='OK'></TD>
</FORM>
<FORM action='index.php' method='GET'>
<INPUT type=HIDDEN name='mode' value='rootadmin'>
<INPUT type=HIDDEN name='func' value='roots'>
<TD width=50%><INPUT type=SUBMIT name='ok' value='Mégsem'>
</FORM>
</TR></TABLE>
<BR>
</TD></TR>
</TABLE>
<BR>
<? if($root->ComputerCount==0){ ?>
<H2>További funkciók</H2>
[ <A class='danger' href='index.php?mode=rootadmin&func=delroot&rootid=<?=$root->ID?>'>Rendszergazda törlése</A> ]<BR>
<BR>
<? } ?>
