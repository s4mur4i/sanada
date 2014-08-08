<H1>Tiltott hálózatok</H1>
<? require_once("design/engine/default_result.php"); ?>
<P>[ <A href='index.php?mode=deniednetadmin&func=newdeniednet'>Új tiltás</A> ]</P>
<? if(count($deniednets)>0){ ?>
<TABLE border=1 cellspacing=0 cellpadding=3>
<TR>
<TH>Hálózat</TH>
<TH>Létrehozva</TH>
<TH>Módosítva</TH>
<TH>Megjegyzés</TH>
<TH>Törlés</TH>
</TR>
<?
	for($i=0;$i<count($deniednets);$i++){
		$dn=$deniednets[$i];
?>
<TR>
<TD><?=ToHTML($dn->Network)?>/<?=$dn->MaskLength?></TD>
<TD>#<?=$dn->CreateByUserID?> (<?=ToHTML($dn->CreateByUserNick)?>) <?=ToHTML($dn->CreateByUserName)?><BR>[<?=StampToDateTime($dn->CreateD)?>]</TD>
<TD>#<?=$dn->ModifyByUserID?> (<?=ToHTML($dn->ModifyByUserNick)?>) <?=ToHTML($dn->ModifyByUserName)?><BR>[<?=StampToDateTime($dn->ModifyD)?>]</TD>
<TD><?=nl2br(ToHTML($dn->Descr))?></TD>
<TD>[
<A href='index.php?mode=deniednetadmin&func=modifydeniednet&id=<?=$dn->ID?>&'>Módosítás</A>
|
<A class='danger' href='index.php?mode=deniednetadmin&func=deldeniednet&id=<?=$dn->ID?>&'>Törlés</A>
]</TD>
</TR>
<?
	}
?>
</TABLE>
<? } else { ?>
<P><I>Nincsenek tiltott hálózatok.</I></P>
<? } ?>
