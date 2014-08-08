<?
	switch($func){
		case "newuser": echo("<H1>Új felhasználó hozzáadása</H1>\n"); break;
		case "modifyuser": echo("<H1>Felhasználó módosítás</H1>\n"); break;
		case "modifyself": echo("<H1>Saját adatok módosítása</H1>\n"); break;
		default: echo("<H1>Programmer error</H1>\n"); break;
	}
?>
<? require_once("design/engine/default_result.php"); ?>
<FORM method=post action=index.php>
<INPUT type=hidden name='mode' value='useradmin'>
<INPUT type=hidden name='func' value='try<?=$func?>'>
<? if($func=="modifyuser"){ ?>
<INPUT type=hidden name=luserid value=<?=$luser->ID?>>
<? } ?>
<TABLE border=0 cellspacing=3 cellpadding=3>
<TR><TH align=right>Nick:</TH><TD class='data'><INPUT type=TEXT name='nick' value='<?=ToHTML($nick)?>' size=8>
<? if($func=="modifyuser"){ ?>
<? if($luser->DeleteD==0){ ?>
[ <A class='danger' href='index.php?mode=useradmin&func=deluser&luserid=<?=$luser->ID?>'>Törlés</A> ]
<? } ?>
<? } ?>
</TD></TR>
<TR><TH align=right>Valódi név:</TH><TD class='data'><INPUT type=TEXT name='realname' value='<?=ToHTML($realname)?>' size=30></TD></TR>
<TR><TH align=right>E-mail:</TH><TD class='data'><INPUT type=TEXT name='email' value='<?=ToHTML($email)?>' size=30></TD></TR>
<TR><TH align=right>Jelszó:</TH><TD class='data'><INPUT type=PASSWORD name='pass1' value='<?=ToHTML($pass1)?>'> <? if($func!="newuser"){ ?>(csak ha változtatod)<? } ?></TD></TR>
<TR><TH align=right>Jelszó mégegyszer:</TH><TD class='data'><INPUT type=PASSWORD name='pass2' value='<?=ToHTML($pass2)?>'></TD></TR>
<? if($func!="newuser"){ ?>
<TR><TH align=right>Létrehozva:</TH><TD class='data'><?=StampToDateTime($luser->CreateD)?></TD></TR>
<? if($luser->DeleteD>0){ ?>
<TR><TH align=right>Törölve:</TH><TD class='data danger'><?=StampToDateTime($luser->DeleteD)?> <A class='danger' href='index.php?mode=useradmin&func=undeluser&luserid=<?=$luser->ID?>'>Visszaállítás</A></TD></TR>
<? } ?>
<? } ?>
<?
	echo("<TR><TH align='right' valign='top'>Jogosultságok:</TH><TD class='data'>\n");
	$l = isset($luser)?$luser:new stdClass;
	$l->Rights=$rights;
	for($i=0;$i<count($allrights);$i++){
		if(HasRights($allrights[$i]->ID,$l)==1) $chk=" CHECKED"; else $chk="";
		if($func!="modifyself") echo("<INPUT type=CHECKBOX name='rights[]' value='".$allrights[$i]->ID."'".$chk."> ".ToHTML($allrights[$i]->Name)."<BR>\n");
		else if($chk!="") echo($allrights[$i]->Name."<BR>\n");
	}
	echo("</TD></TR>\n");
?>
<TR><TD colspan=2 align='center'>
<BR>
<TABLE width=200 border=0 cellspacing=0 cellpadding=3><TR align='center'>
<TD width='50%'><INPUT type=SUBMIT name='ok' value='OK'></TD>
</FORM>
<FORM action='index.php' method='GET'>
<? if($func!="modifyself"){ ?>
<INPUT type=HIDDEN name='mode' value='useradmin'>
<INPUT type=HIDDEN name='func' value='users'>
<? } else { ?>
<INPUT type=HIDDEN name='mode' value='home'>
<? } ?>
<TD width='50%'><INPUT type=SUBMIT name='ok' value='Mégsem'></TD>
</FORM>
</TR></TABLE>
<BR>
</TABLE>
</FORM>
