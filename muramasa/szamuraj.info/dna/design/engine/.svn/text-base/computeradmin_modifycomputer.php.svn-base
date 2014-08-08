<? if($func=="modifycomputer"){ ?>
<H1>Gép módosítása</H1>
<? } else { ?>
<H1>Új gép felvitele</H1>
<? } ?>
<TABLE border=0 cellspacing=0 cellpadding=3>
<TR><TH>Szabad IP-címek:</TH></TR>
<TR><TD>
<?
	echo("<TABLE border=0 cellspacing=0 cellpadding=3>\n");
	for($i=0;$i<count($revdomains);$i++){
		if($i%4==0)
			echo("<TR>\n");
		echo("<TD>");
		echo($revdomains[$i]->IPBegin.".");
		echo("<SELECT name='revdomain".$i."' style='text-align: right;'>\n");
		for($j=0;$j<count($revdomains[$i]->freeips);++$j){
			echo("<OPTION>".$revdomains[$i]->freeips[$j]."</OPTION>\n");
		}
		echo("<OPTION value='---'>(".count($revdomains[$i]->freeips)." db)</OPTION>\n");
		echo("</SELECT>\n");
		echo("</TD>\n");
		if($i%4==3 || $i==count($revdomains)-1)
			echo("</TR>\n");
	}
	echo("</TABLE>\n");
?>
</TD></TR>
</TABLE>
<TABLE cellpadding=2 cellspacing=3>
<FORM method=POST action='index.php'>
<INPUT type=hidden name='mode' value='computeradmin'>
<INPUT type=hidden name='func' value='try<?=$func?>'>
<? if($func=="modifycomputer"){ ?>
<INPUT type=HIDDEN name='computerid' value='<?=$computer->ID?>'>
<? } ?>
<TR><TD colspan=2 align=center><H2>Gépadatok</H2>
<? require_once("design/engine/default_result.php"); ?>
<? if(isset($allow_force) && $allow_force==1){ ?>
<DIV class='large result' style='border: 1px solid red; font-family: monospace;'>Ha TÉNYLEG TUDOD, hogy mit teszel:<BR>--force: <INPUT type=CHECKBOX name=force value=1 style='vertical-align: middle'></DIV>
<BR>
<? } ?>
<? if($func=="modifycomputer"){ ?>
Létrehozva: <?=StampToDateTime($computer->CreateD)?><BR>
Módosítva: <?=StampToDateTime($computer->ModifyD)?><BR>
<? if($computer->BannedUntilD>TIME){ ?>
<FONT class='danger'>Kitiltva: <?=StampToDateTime($computer->BannedUntilD)?>-ig</FONT><BR>
<? } ?>
<? } ?>
</TD></TR>
<TR><TH align='right'>Host:</TH>
<TD class='data'><INPUT type=text name=namebegin size=20 maxlength=127 value='<?=ToHTML($namebegin)?>'>.<SELECT name=namedomainid>
<?
	for($i=0;$i<count($forwdomains);$i++){
		$row=$forwdomains[$i];
		if($namedomainid==$row->ID) $sel=" SELECTED"; else $sel="";
		echo("<OPTION value='".$row->ID."'".$sel.">".$row->NameEnd."</OPTION>\n");
	}
?>
</SELECT></TD></TR>
<TR><TH align='right'>IP:</TH>
<TD class='data'><SELECT name=ipdomainid>
<?
	for($i=0;$i<count($revdomains);$i++){
		$row=$revdomains[$i];
		if($ipdomainid==$row->ID) $sel=" SELECTED"; else $sel="";
		echo("<OPTION value='".$row->ID."'".$sel.">".$row->IPBegin."</OPTION>\n");
	}
?>
</SELECT>.<INPUT type=text size=3 maxlength=3 name=ipend value='<?=ToHTML($ipend)?>'></TD></TR>
<TR><TH align='right'>Kártya:</TH>
<TD class='data'>HW (Mac):<INPUT type=text name=hwaddr size=18 maxlength=17 value='<?=ToHTML($hwaddr)?>'></TD></TR>
<TR><TH align='right'>Helye:</TH><TD class='data' valign=middle>Épület: <INPUT type=TEXT size=2 maxsize=1 name='building' value='<?=ToHTML($building)?>'> Szoba: <INPUT type=TEXT name='room' size=17 maxsize=16 value='<?=ToHTML($room)?>'></TD></TR>
<TR><TH align='right'>Érvényesség:</TH><TD class='data'>
<? if($func=="newcomputer"){ ?>
<INPUT type='RADIO' name='validuntil_type' value=1<?=$validuntil_type==1?" CHECKED":""?>> Normál (<?=d_ColoredStampToDateTime(NEXT_TERMINATION_STAMP)?>)<BR>
<INPUT type='RADIO' name='validuntil_type' value=2<?=$validuntil_type==2?" CHECKED":""?>> Egyedi <INPUT type=TEXT name='validuntil_date' value='<?=ToHTML(isset($validuntil_date)?$validuntil_date:"")?>'><BR>
<INPUT type='RADIO' name='validuntil_type' value=3<?=$validuntil_type==3?" CHECKED":""?>> Örökre<BR>
<? } else { ?>
<? if($computer->ValidUntilD==0){ ?>
<SPAN class='good'>Örökre</SPAN>
<? } else { ?>
<?=d_ColoredStampToDateTime($computer->ValidUntilD)?> (Legutóbbi levél: <?=StampToDateTime($computer->LastValidityWarningD)?>)<br />
<? } ?>
[ <A href='index.php?mode=computeradmin&func=modifyvaliduntild&computerid=<?=$computer->ID?>'>Szerkeszt</A> ]
<? } ?>
</TD></TR>
<TR><TH align='right'>Hozzáférés típusa:</TH><TD class='data'>
<SELECT name='accessclass'>
<?
	$sel0=""; $sel1=""; $sel2=""; $sel3="";
	if($accessclass==ACCESSCLASS_PROTECTED) $sel0=" SELECTED";
	if($accessclass==ACCESSCLASS_ADVANCED) $sel1=" SELECTED";
	if($accessclass==ACCESSCLASS_SERVER) $sel2=" SELECTED";
	if($accessclass==ACCESSCLASS_CUSTOM) $sel3=" SELECTED";
?>
<OPTION value='<?=ACCESSCLASS_PROTECTED?>'<?=$sel0?>>Védett</OPTION>
<OPTION value='<?=ACCESSCLASS_ADVANCED?>'<?=$sel1?>>Haladó</OPTION>
<OPTION value='<?=ACCESSCLASS_SERVER?>'<?=$sel2?>>Szerver</OPTION>
<OPTION value='<?=ACCESSCLASS_CUSTOM?>'<?=$sel3?>>Egyedileg beállított</OPTION>
</SELECT></TD></TR>
<? if($isofficial==1) $chk=" CHECKED"; else $chk=""; ?>
<TR><TH align='right'>Publikálás:</TH>
<TD class='data'>
<TABLE border=0 cellspacing=0 cellpadding=0 align='right' width=200><TR><TD class='small'>
Kerüljön fel a www.csoma.elte.hu website "Hivatalos kollégiumi szerverek" oldalára.
</TD></TR></TABLE>
<INPUT type=CHECKBOX name='isofficial' value='1'<?=$chk?>>
</TD></TR>
</TABLE>
<H2>Rendszergazda adatok</H2>
<TABLE>
<TR><TH align='right'>Rendszergazda:</TH><TD class='data'><SELECT name=rootid>
<OPTION value=-1>Új, az alábbi adatokkal</OPTION>
<?
	foreach($roots as $row){
		if($rootid==$row->ID) $sel=" SELECTED"; else $sel="";
		echo("<OPTION value='".$row->ID."'".$sel.">".ToHTML($row->RealName)." (".ToHTML($row->PersonalID).")</OPTION>\n");
	}
?>
</SELECT>
<? if($rootid!=0){ ?><A href='index.php?mode=rootadmin&func=modifyroot&rootid=<?=$rootid?>'>&gt;&gt;&gt;</A><? } ?>
</TD></TR>
<TR><TH align='right'>EHA-kód:</TH><TD class='data' valign=middle><INPUT type=text name=personalid size=12 maxlength=16 value='<?=ToHTML($personalid)?>'></TD></TR>
<TR><TH align='right'>Neve:</TH><TD class='data' valign=middle><INPUT type=text name=realname size=30 maxlength=64 value='<?=ToHTML($realname)?>'></TD></TR>
<TR><TH align='right'>Helye:</TH><TD class='data' valign=middle>Épület: <INPUT type=TEXT size=2 maxsize=1 name='rootbuilding' value='<?=ToHTML($rootbuilding)?>'> Szoba: <INPUT type=TEXT name='rootroom' size=17 maxsize=16 value='<?=ToHTML($rootroom)?>'></TD></TR>
<TR><TH align='right'>Email:</TH><TD class='data' valign=middle><INPUT type=text name=email size=30 maxlength=128 value='<?=ToHTML($email)?>'></TD></TR>
<TR><TD colspan=2 align='center'>
<BR>
<TABLE width=200 border=0 cellspacing=0 cellpadding=3><TR align='center'>
<? if($func=="newcomputer"){ ?>
<TD width=50%><INPUT type=SUBMIT name='ok' value='Létrehoz'><TD>
<? } else { ?>
<TD width=50%><INPUT type=SUBMIT name='ok' value='Módosít'><TD>
<? } ?>
</FORM>
<FORM action='index.php' method='GET'>
<? if($func=="modifycomputer"){ ?>
<INPUT type=HIDDEN name='mode' value='search'>
<INPUT type=HIDDEN name='func' value='search'>
<!--<INPUT type=HIDDEN name='computerid' value='<?=$computer->ID?>'>-->
<? } else { ?>
<INPUT type=HIDDEN name='mode' value='search'>
<INPUT type=HIDDEN name='func' value='search'>
<? } ?>
<TD width=50%><INPUT type=SUBMIT name='ok' value='Mégsem'><TD>
</FORM>
</TR></TABLE>
<BR>
</TD></TR>
</TABLE>
<? if($func=="modifycomputer"){ ?>
<H2>További funkciók</H2>
<TABLE border=0 cellspacing=0 cellpadding=3><TR align='center'>
<TD>[ <A class='danger' href='index.php?mode=computeradmin&func=delcomputer&computerid=<?=$computer->ID?>'>Számítógép törlése</A> ]</TD>
<TD>[
<? if($computer->BannedUntilD>TIME){ ?>
Kitiltva: <?=StampToDateTime($computer->BannedUntilD)?>-ig
<A href='index.php?mode=computeradmin&func=unbancomputer&computerid=<?=$computer->ID?>'>Kitiltás feloldása</A>
<? } else { ?>
<A class='danger' href='index.php?mode=computeradmin&func=bancomputer&computerid=<?=$computer->ID?>'>Időleges kitiltás</A>
<? } ?>
]</TD>
<? if(3==4){ ?>
<TD>[
<? if($computer->LimitedUntilD>TIME){ ?>
Korlátozva: <?=StampToDateTime($computer->LimitedUntilD)?>-ig
<A href='index.php?mode=computeradmin&func=unlimitcomputer&computerid=<?=$computer->ID?>'>Korlátozás feloldása</A>
<? } else { ?>
<A class='danger' href='index.php?mode=computeradmin&func=limitcomputer&computerid=<?=$computer->ID?>'>Időleges korlátozás</A>
<? } ?>
]</TD>
<? } ?>
</TR></TABLE>
<BR>
<? } ?>
