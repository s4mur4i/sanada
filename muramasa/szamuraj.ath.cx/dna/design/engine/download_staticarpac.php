<?
	for($i=0;$i<count($computers);$i++){
		$c=$computers[$i];
		if($c->HWAddr!=""){
?>
<?=$c->IP?>	<?=HWAddr_AddColons($c->HWAddr)?><? if($mode=="staticarpac" || $mode=="staticarpacb"){ ?>	<?=$c->AccessClass?><? if($mode=="staticarpacb"){ ?>	<?=(($c->LimitedUntilD>TIME)?1:0)?><? } ?><? } ?><? if($mode=="staticarphost"){ ?>	<?=$c->NameBegin?><? } ?>

<?
		}
	}
?>
