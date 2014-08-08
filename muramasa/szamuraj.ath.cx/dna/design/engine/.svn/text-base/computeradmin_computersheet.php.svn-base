<html>
<head>
<title>Számítógép Adatlap</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
</body>
<? if(!isset($statementonly) || $statementonly==0){ ?>
<CENTER>
<H1>Számítógép adatlap</H1>
<H3>Kliens adatok</H3>
<TABLE cellpadding=2>
<TR><TD align=right><B>Gép helye:</B></TD><TD><?=$computer->Building?>/<?=$computer->Room?></TD></TR>
<TR><TD align=right><B>Neve (host, gazda):</B></TD><TD><?=$computer->NameBegin?></TD></TR>
<TR><TD align=right><B>Domain (körzet):</B></TD><TD>.<?=$forwdom->NameEnd?></TD></TR>
<TR><TD align=right><B>IP:</B></TD><TD><?=$revdom->IPBegin?>.<?=$computer->IPEnd?></TD></TR>
<TR><TD align=right><B>Lejárat dátuma:</B></TD><TD><?=$computer->ValidUntilD==0?"Nem jár le":StampToDateTime($computer->ValidUntilD)?></TD></TR>
</TABLE>
<? if($forwdom->ClientConfig!="" || $revdom->ClientConfig!=""){ ?>
<H3>Hálózati beállítások</H3>
<? if($forwdom->ClientConfig!="") echo($forwdom->ClientConfig); ?>
<? if($revdom->ClientConfig!="") echo($revdom->ClientConfig); ?>
<? } ?>
<BR>
<? } ?>
<TABLE cellpadding=2>
<TR><TD colspan=2 align=left>
<CENTER><FONT size=+2>Nyilatkozat</FONT></CENTER><BR>
<BR>
Az ELTENET hálózati szabályzatot (http://darmol.elte.hu/ELTE_Halozati_Szabalyzat.html)<BR>
és a KCSSK hálózati szabályzatot (http://www.csoma.elte.hu/net/csomanet/szabalyzat)<BR>
elfogadom és betartom:<BR>
<BR>
<BR>
<BR>
<BR>
</TD></TR>
<TR><TD></TD><TD align=center>.......................................................................</TD></TR>
<TR><TD></TD><TD align=center><?=$root->RealName?> (<?=$root->PersonalID?>)</TD></TR>
<TR><TD></TD><TD align=center><?=$root->Building?>/<?=$root->Room?><BR><?=$root->Email?></TD></TR>
</TABLE>
<CENTER><A href='index.php?mode=search&func=search&search=<?=ToURL($computer->NameBegin.".")?>'>...</A></CENTER>
<BR>
<?=$output?>
</CENTER>
</body>
