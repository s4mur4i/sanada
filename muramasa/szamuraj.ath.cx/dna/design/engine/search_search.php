<? if($print==1){ ?>
<H1>Géplista</H1>
Keresett: '<?=ToHTML($search)?>'<BR>
<? if($ban==0){ ?>Nem tiltott gépek<BR><? } ?>
<? if($ban==1){ ?>Tiltott gépek<BR><? } ?>
<? if($validitystate!=-1){ ?>Fizetettség: <?=$d_validitystates[$validitystate]?> [<?=ToHTML($reftime)?>]<BR><? } ?>
<? if($accessclass!=-1){ ?>Elérés típusa: <?=$d_accessclasses[$accessclass]?><BR><? } ?>
<BR>
<? } else { ?>
<TABLE border=0 cellpadding=3 cellspacing=0 border=0><TR valign='top'>
<FORM method=GET action=index.php>
<INPUT type=hidden name='mode' value=search>
<INPUT type=hidden name='func' value=search>
<INPUT type=hidden name=print value=0>
<TD> <!-- outer -->

<TABLE cellspacing=0 cellpadding=3>
<TR valign='top'>
<TD align='right'>Keresendő:</TD>
<TD>
<INPUT style='font-family: monospace' type=text name=search size=32 maxlength=127 value='<?=ToHTML($search)?>'><BR>
(<A target='_blank' href='http://www.regular-expressions.info/'>Regular expression</A>)<BR>
</TD>
</TR>
<TR><TD align='right'>Letiltás:</TD><TD>
<SELECT name='ban'>
<OPTION value='-1'>Mindegy</OPTION>
<?
	if($ban==0) $sel=" SELECTED"; else $sel="";
	echo("<OPTION value='0'".$sel.">Nem tiltott</OPTION>\n");
	if($ban==1) $sel=" SELECTED"; else $sel="";
	echo("<OPTION value='1'".$sel.">Tiltott</OPTION>\n");
?>
</SELECT>
</TD></TR>
<TR valign='top'><TD align='right'>Érvényesség:</TD><TD>

<SELECT name='validitystate'>
<OPTION value='-1'>Mindegy</OPTION>
<?
	foreach(array(VALIDITYSTATE_INVALID,VALIDITYSTATE_VALID,VALIDITYSTATE_FOREVER) as $value){
		if($validitystate==$value) $sel=" SELECTED";
		else $sel="";
		echo("<OPTION value='".$value."'".$sel.">".$d_validitystates[$value]."</OPTION>\n");
	}
?>
</SELECT><BR>
<INPUT type=RADIO name='custom_reftime' value=0<?=$custom_reftime==0?" CHECKED":""?>> Mosthoz képest<BR>
<INPUT type=RADIO name='custom_reftime' value=1<?=$custom_reftime==1?" CHECKED":""?>> Adott dátumhoz képest:
<INPUT type=TEXT name='reftime' value='<?=ToHTML($reftime)?>'><BR>
</TD></TR>
<TR><TD align='right'>Elérés típusa:</TD><TD>
<SELECT name='accessclass'>
<OPTION value='-1'>Mindegy</OPTION>
<?
	foreach(array(ACCESSCLASS_PROTECTED,ACCESSCLASS_ADVANCED,ACCESSCLASS_SERVER,ACCESSCLASS_CUSTOM) as $value){
		if($accessclass==$value) $sel=" SELECTED";
		else $sel="";
		echo("<OPTION value='".$value."'".$sel.">".$d_accessclasses[$value]."</OPTION>\n");
	}
?>
</SELECT>
</TD></TR>
</TABLE>

</TD><TD> <!-- outer -->

<TABLE border=0 cellspacing=0 cellpadding=3>
<TR><TD>Rendezés:</TD><TD><SELECT name=orderby>
<?
	for($i=0;$i<count($orders);$i++){
		if($i==$orderby)  $sel=" SELECTED"; else $sel="";
		echo("<OPTION value='".$i."'".$sel.">".$orders[$i]->Name."</OPTION>\n");
	}
?>
</SELECT></TD></TR>
</TABLE>

</TD><TD> <!-- outer -->
<INPUT name=ok type=submit value='Keres'>
</TD> <!-- outer -->
</FORM>
</TR></TABLE>
<BR>
<? } /* end of if not printing */ ?>
<? if($do_search==1){ ?>
<H2>A keresés eredménye</H2>
<? require_once("design/engine/default_result.php"); ?>
Találatok száma: <?=count($computers)?><BR>
<? if(HasRights("NEWSLETTERADMIN",$user)==1){ ?>[ <A href='index.php?mode=search&func=search_mail'>Levél nekik</A> ]<BR><? } ?>
<BR>
<? } ?>
<? if($search!="" && count($computers)>0){ ?>
<TABLE cellpadding=3 cellspacing=0 border=1>
<? if($print!=1){ ?><TH align=center>&nbsp;</TH><? } ?>
<TH align=center>IP</TH>
<TH align=center>Gép</TH>
<TH align=center>Helye</TH>
<TH align=center>HW (Mac)</TH>
<TH align=center>Rendszergazda</TH>
<TH align=center>Érvényes</TH>
</TR>
<?
	foreach($computers as $row){
		echo("<TR>");
?>
<? if($print!=1){ ?>
<TD nowrap>
<? if(HasRights("COMPUTERADMIN",$user)==1){ ?><A href='index.php?mode=computeradmin&func=modifycomputer&computerid=<?=$row->ID?>'><IMG src='images/modify.gif' border=0 title='Módosítás'></A><? } ?>
<? if(HasRights("COMPUTERADMIN",$user)==1){ ?><A href='index.php?mode=computeradmin&func=modifycomputer&do_copy=1&computerid=<?=$row->ID?>'><IMG src='images/copy.gif' border=0 title='Másolás'></A><? } ?>
<A title='Nyomtatvány' href='index.php?mode=computeradmin&func=print&computerid=<?=$row->ID?>'>[ny]</A>
</TD>
<? } ?>
<TD nowrap><?=$row->IP?>
<?
	if($row->IsOfficial==1) echo(" <FONT class='good'>Publikált</FONT>");
	switch($row->AccessClass){
		case ACCESSCLASS_ADVANCED: echo(" <FONT class='warning'>Haladó</FONT>"); break;
		case ACCESSCLASS_SERVER: echo(" <FONT class='good'>Szerver</FONT>"); break;
		case ACCESSCLASS_CUSTOM: echo(" <FONT class='danger'>Egyedi</FONT>"); break;
		default: break;
	}
?>
</TD>
<TD nowrap title='<?=ToHTML($row->Name)?>'><?=ToHTML($row->NameBegin)?></TD>
<TD nowrap><?=ToHTML($row->Building)?>/<?=ToHTML($row->Room)?></TD>
<TD nowrap><?=HWAddr_AddColons($row->HWAddr)?></TD>
<TD nowrap><? if($print!=1){ ?><A title='<?=ToHTML($row->Email)?>' href='index.php?mode=rootadmin&func=modifyroot&rootid=<?=$row->RootID?>' style='text-decoration: none'><? } ?><?=ToHTML($row->RealName)?> (<?=ToHTML($row->RootBuilding)?>/<?=ToHTML($row->RootRoom)?>,<?=ToHTML($row->PersonalID)?>)<? if($print!=1){ ?></A><? } ?></TD>
<TD nowrap>
<?
	if($row->ValidUntilD==0)
		echo("<SPAN class='good'>Örökre</SPAN>");
	else {
		if($row->ValidUntilD<$reftimed) echo("Lejárt: ");
		echo(d_ColoredStampToDateTime($row->ValidUntilD,$reftimed,""));
	}
	if($row->BannedUntilD>$reftimed) echo(" <SPAN class='danger'>Tiltott: ".StampToDateTime($row->BannedUntilD)."</SPAN><BR>");
?>
</TD>
</TR>
<?
	} // end record (while)
?>
</TABLE>
<BR>
<? if($print!=1){ ?> 
<DIV align=right><FORM action=index.php method=post>
<INPUT type=hidden name='mode' value='search'>
<INPUT type=hidden name='func' value='search'>
<!--
<INPUT type=hidden name='search' value='<?=ToHTML($search)?>'>
<INPUT type=HIDDEN name='ban' value='<?=ToHTML($ban)?>'>
<INPUT type=HIDDEN name='validitystate' value='<?=ToHTML($validitystate)?>'>
<INPUT type=HIDDEN name='custom_reftime' value='<?=ToHTML($custom_reftime)?>'>
<INPUT type=HIDDEN name='reftime' value='<?=ToHTML($reftime)?>'>
<INPUT type=HIDDEN name='accessclass' value='<?=ToHTML($accessclass)?>'>
<INPUT type=hidden name='orderby' value='<?=ToHTML($orderby)?>'>
-->
<INPUT type=hidden name='print' value=1>
<INPUT type=submit name='ok' value='Nyomtatható változat'>
</FORM></DIV>
<BR>
<? } ?>
<?
	} // end of if there are records
?>
