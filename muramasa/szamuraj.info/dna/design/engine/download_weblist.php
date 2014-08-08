<?
	for($i=0;$i<count($computers);$i++){
		$c=$computers[$i];
?>
<?=$c->IP?>	<?=HWAddr_AddColons($c->HWAddr)?>	<?=$c->AccessClass?>	<?=$c->NameBegin?>	<?=$c->IsOfficial?>	<?=addslashes($c->PersonalID)?>

<?
	}
?>
