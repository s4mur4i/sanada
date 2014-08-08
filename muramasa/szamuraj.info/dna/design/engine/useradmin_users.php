<H1>DNA felhasználók</H1>
<? require_once("design/engine/default_result.php"); ?>
<TABLE border=1 cellspacing=0 cellpadding=3>
<TR>
<TH>Login</TH>
<TH>Valódi név</TH>
<TH>E-mail</TH>
<TH>Jogosultságok</TH>
</TR>
<?
	for($i=0;$i<count($users);$i++){
		$luser=$users[$i];
		if($luser->DeleteD>0) $trclass=" class='danger'"; else $trclass="";
?>
<TR<?=$trclass?> valign='top'>
<TD><A href='index.php?mode=useradmin&func=modifyuser&luserid=<?=$luser->ID?>'><?=ToHTML($luser->Nick)?></A></TD>
<TD><?=ToHTML($luser->RealName)?></TD>
<TD><?=ToHTML($luser->Email)?></TD>
<TD>
<?
	$hasrights=0;
	for($j=0;$j<count($allrights);$j++){
		if(HasRights($allrights[$j]->ID,$luser)==1){
			echo(ToHTML($allrights[$j]->Name)."<BR>\n");
			$hasrights=1;
		}
	}
	if($hasrights==0) echo("<BR>\n");
?>
</TD>
</TR>
<?
	}
?>
</TABLE>
<BR>
Összesen <?=count($users)?> felhasználó<BR>
<BR>
