<H1>Domain módosítás</H1>
<? require_once("design/engine/default_result.php"); ?>
<TABLE cellpadding=2 cellspacing=3>
<TR><FORM method=post action=index.php>
<INPUT type=hidden name='mode' value='domainadmin'>
<INPUT type=hidden name='func' value='try<?=$func?>'>
<? if($func=="modifydomain"){ ?>
<INPUT type=hidden name=domainid value='<?=$domain->ID?>'>
<? } else { ?>
<INPUT type=hidden name=domaintype value='<?=ToHTML($domaintype)?>'>
<? } ?>
<? $_options = array(DOMAINTYPE_FORWARD => "Normál", DOMAINTYPE_REVERSE => "Fordított"); ?>
<TR><TH align=right>Típus:</TH><TD class='data'><?=ToHTML($_options[$domaintype])?></td></tr>
<? if($func=="modifydomain"){ ?>
<? if($domaintype==DOMAINTYPE_FORWARD){ ?>
<TR><TH align=right>Domainnév:</TH><TD class='data'><?=ToHTML($nameend)?></TD></TR>
<? } else { ?>
<TR><TH align=right>IP eleje:</TH><TD class='data'><?=ToHTML($ipbegin)?></TD></TR>
<? } ?>
<TR><TH align=right>Serial:</TH><TD class='data'><tt><?=date("Ymd",$domain->ModifyD)?><u><?=PreZero($domain->SOASerial,2)?></u></tt></TD></TR>
<? } else { ?>
<? if($domaintype==DOMAINTYPE_FORWARD){ ?>
<TR><TH align=right>Domainnév:</TH><TD class='data'><INPUT type=text name=nameend size=32 maxlength=128 value='<?=ToHTML($nameend)?>'></TD></TR>
<? } else { ?>
<TR><TH align=right>IP eleje:</TH><TD class='data'><INPUT type=text name=ipbegin size=16 maxlength=16 value='<?=ToHTML($ipbegin)?>'></TD></TR>
<? } ?>
<? } ?>
<TR><TH align=right>TTL:</TH><TD class='data'><INPUT type=text name=ttl size=11 maxlength=11 value='<?=ToHTML($ttl)?>'></TD></TR>
<TR><TH align=right>Server:</TH><TD class='data'><INPUT type=text name=soaserver size=32 maxlength=255 value='<?=ToHTML($soaserver)?>'></TD></TR>
<TR><TH align=right>Admin Email:</TH><TD class='data'><INPUT type=text name=soaemail size=32 maxlength=255 value='<?=ToHTML($soaemail)?>'></TD></TR>
<TR><TH align=right>Refresh:</TH><TD class='data'><INPUT type=text name=soarefresh size=11 maxlength=11 value='<?=ToHTML($soarefresh)?>'></TD></TR>
<TR><TH align=right>Retry:</TH><TD class='data'><INPUT type=text name=soaretry size=11 maxlength=11 value='<?=ToHTML($soaretry)?>'></TD></TR>
<TR><TH align=right>Expire:</TH><TD class='data'><INPUT type=text name=soaexpire size=11 maxlength=11 value='<?=ToHTML($soaexpire)?>'></TD></TR>
<TR><TH align=right>NegTTL:</TH><TD class='data'><INPUT type=text name=soanegttl size=11 maxlength=11 value='<?=ToHTML($soanegttl)?>'></TD></TR>
<TR><TH align=right>Egyéb:</TH><TD class='data'><TEXTAREA name=text maxlenght=32768 maxsize=32768 cols=60 rows=20 wrap=virtual><?=ToHTML($text)?></TEXTAREA></TD></TR>
<TR><TH align=right>Kliens beállítások:</TH><TD class='data'><TEXTAREA name=clientconfig maxlenght=32768 maxsize=32768 cols=60 rows=10 wrap=virtual><?=ToHTML($clientconfig)?></TEXTAREA></TD></TR>
<TR><TD colspan=2 align='center'>
<BR>
<TABLE width=200 border=0 cellspacing=0 cellpadding=3><TR align='center'>
<TD width='50%'><INPUT type=SUBMIT name='ok' value='OK'></TD>
</FORM>
<FORM action='index.php' method='GET'>
<INPUT type=HIDDEN name='mode' value='domainadmin'>
<INPUT type=HIDDEN name='func' value='domains'>
<TD width='50%'><INPUT type=SUBMIT name='ok' value='Mégsem'></TD>
</FORM>
</TR></TABLE>
<BR>
</TABLE>
