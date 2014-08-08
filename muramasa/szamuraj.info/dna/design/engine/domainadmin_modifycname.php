<? if($func=="newcname"){ ?>
<H1>Új CNAME</H1>
<? } else { ?>
<H1>CNAME módosítása</H1>
<? } ?>
<? require_once("design/engine/default_result.php"); ?>
<TABLE cellpadding=2 cellspacing=3>
<TR><FORM method='post' action='index.php'>
<INPUT type=hidden name='mode' value='domainadmin'>
<INPUT type=hidden name='func' value='try<?=$func?>'>
<? if($func=="modifycname"){ ?>
<INPUT type=HIDDEN name='cnameid' value='<?=$cname->ID?>'>
<? } ?>
<? if(isset($allow_force) && $allow_force==1){ ?>
<TR><TD colspan=2 align='center' class='result' style='border: 1px solid red; font-family: monospace;'>Ha TÉNYLEG TUDOD, hogy mit teszel:<BR>--force: <INPUT type=CHECKBOX name=force value=1 style='vertical-align: middle'></TD></TR>
<? } ?>
<TR><TH align='right'>Forrás név:</TD><TD class='data'><INPUT type=TEXT name='namebegin1' value='<?=ToHTML($namebegin1)?>'></TD></TR>
<TR><TH align='right'>Forrás domain:</TD><TD class='data'>
<SELECT name=namedomainid1>
<OPTION value='0'> --- Válasszon! --- </OPTION>
<?
	for($i=0;$i<count($forwarddomains);$i++){
		$row=$forwarddomains[$i];
		if($namedomainid1==$row->ID || count($forwarddomains)==1) $sel=" SELECTED"; else $sel="";
		echo("<OPTION value='".$row->ID."'".$sel.">".$row->NameEnd."</OPTION>\n");
	}
?>
</SELECT>
</TD></TR>
<TR><TH align='right'>Cél:</TD><TD class='data'><INPUT type=TEXT name='target' value='<?=ToHTML($target)?>'></TD></TR>
<TR><TD colspan=2 align='center'>
<B>Megjegyzés:</B><BR>
<TEXTAREA cols=40 rows=5 wrap=virtual name='descr'><?=ToHTML($descr)?></TEXTAREA><BR>
</TD></TR>
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
