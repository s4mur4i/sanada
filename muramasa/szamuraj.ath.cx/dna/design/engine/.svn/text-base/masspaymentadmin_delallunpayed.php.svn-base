<H1>Az összes anyagilag rendezetlen gép törlése</H1>
<? require("design/engine/default_result.php"); ?>
<P><STRONG>Biztosan törölni kívánja az összes "Lejárt" "Érvényesség"-ű gépet?</STRONG></P>
<P>Összesen <SPAN class='large danger'><?=count($computers)?></SPAN> számítógép.</P>
<TABLE border=1 cellspacing=0 cellpadding=2>
<TR><TH>IP</TH><TH>Gép</TH><TH>Rendszergazda</TH></TR>
<?
	for($i=0;$i<count($computers);$i++){
		echo("<TR>");
		echo("<TD>".$computers[$i]->IP."</TD>");
		echo("<TD>".$computers[$i]->Name."</TD>");
		echo("<TD>".$computers[$i]->RealName."</TD>");
		echo("</TR>\n");
	}
?>
</TABLE>
<BR>
<TABLE width=600 border=0 cellspacing=0 cellpadding=3><TR>
<FORM action='index.php' method='POST'>
<INPUT type=HIDDEN name='mode' value='masspaymentadmin'>
<INPUT type=HIDDEN name='func' value='trydelallunpayed'>
<TD align='left'><INPUT type=IMAGE src='design/images/skull.png' alt='Igen' title='Igen' name='ok' value='Igen'></TD>
</FORM>
<FORM action='index.php' method='GET'>
<INPUT type=HIDDEN name='mode' value='masspaymentadmin'>
<INPUT type=HIDDEN name='func' value='paymenu'>
<TD align='right'><INPUT type=IMAGE src='design/images/peace.png' alt='Nem' title='Nem' name='ok' value='Nem'></TD>
</FORM>
</TR></TABLE>
<BR>
