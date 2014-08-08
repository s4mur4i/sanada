<H1>Domain-ek</H1>
<? if(HasRights("DOMAINADMIN",$user)==1){ ?>
<p>[
<a href='index.php?mode=domainadmin&func=newdomain&domaintype=<?=DOMAINTYPE_FORWARD?>'>Új normál domain</a>
|
<a href='index.php?mode=domainadmin&func=newdomain&domaintype=<?=DOMAINTYPE_REVERSE?>'>Új folrdított domain</a>
]</p>
<? } ?>
<? require_once("design/engine/default_result.php"); ?>
<TABLE border=1 cellspacing=0 cellpadding=3>
<TR>
<TH>Zóna</TH>
<TH>Utolsó módosítás</TH>
<TH>Napi #</TH>
<TH>Utolsó export</TH>
<TH>Gépek</TH>
<TH>CNAME-ek</TH>
<? if(HasRights("DOMAINADMIN",$user)==1){ ?>
<TH>&nbsp;</TH>
<? } ?>
</TR>
<?
	for($i=0;$i<count($domains);$i++){
		$domain=$domains[$i];
?>
<TR valign='top'>
<? if($domain->DomainType==DOMAINTYPE_FORWARD){ ?>
<TD>Normál: <?=ToHTML($domain->NameEnd)?></TD>
<? } else { ?>
<TD>Fordított: <?=ToHTML($domain->IPBegin)?></TD>
<? } ?>
<TD><TT><?=StampToDateTime($domain->ModifyD)?></TT></TD>
<TD align='right'><?=ToHTML(PreZero($domain->SOASerial,2))?></TD>
<TD><TT><?=StampToDateTime($domain->LastExportD)?></TT></TD>
<TD align='right'><?=$domain->ComputerCount?></TD>
<TD align='right'><?=$domain->CnameCount?></TD>
<? if(HasRights("DOMAINADMIN",$user)==1){ ?>
<TD nowrap>[
<A href='index.php?mode=domainadmin&func=modifydomain&domainid=<?=$domain->ID?>'>Módosítás</A>
<? if($domain->ComputerCount==0){ ?>
|
<A class='danger' href='index.php?mode=domainadmin&func=deldomain&domainid=<?=$domain->ID?>'>Törlés</A>
<? } ?>
]</TD>
<? } ?>
</TR>
<?
	}
?>
</TABLE>
<BR>
Összesen <?=count($domains)?> domain<BR>
<BR>
<?
	for($i=0;$i<count($domains);$i++) if($domains[$i]->DomainType==DOMAINTYPE_FORWARD){
?>
<H2><?=ToHTML($domains[$i]->NameEnd)?> CNAME-ek</H2>
[ <A href='index.php?mode=domainadmin&func=newcname&namedomainid1=<?=$domains[$i]->ID?>'>Új CNAME</A> ]<BR>
<BR>
<?
		if(count($domains[$i]->cnames)>0){
?>
<TABLE border=1 cellspacing=0 cellpadding=3>
<TR>
<TH>Forrás</TH>
<TH>Cél</TH>
<TH>Leírás</TH>
<? if(HasRights("COMPUTERADMIN|DOMAINADMIN")==1){ ?>
<TH>&nbsp;</TH>
<? } ?>
</TR>
<?
			for($j=0;$j<count($domains[$i]->cnames);$j++){
?>
<TR valign='top'>
<TD><?=ToHTML($domains[$i]->cnames[$j]->NameBegin1)?></TD>
<TD><?=ToHTML($domains[$i]->cnames[$j]->Target)?></TD>
<? if($domains[$i]->cnames[$j]->Descr!=""){ ?>
<TD><?=nl2br(ToHTML($domains[$i]->cnames[$j]->Descr))?></TD>
<? } else { ?>
<TD>&nbsp;</TD>
<? } ?>
<? if(HasRights("COMPUTERADMIN|DOMAINADMIN")==1){ ?>
<TD nowrap>[
<A href='index.php?mode=domainadmin&func=modifycname&cnameid=<?=$domains[$i]->cnames[$j]->ID?>'>Módosítás</A>
|
<A class='danger' href='index.php?mode=domainadmin&func=delcname&cnameid=<?=$domains[$i]->cnames[$j]->ID?>'>Törlés</A>
]</TD>
<? } ?>
</TR>
<?
			}
?>
</TABLE>
<?
		} else echo("<DIV><I>Nincsenek CNAME-ek</I></DIV>\n");
	}
?>
<BR>
