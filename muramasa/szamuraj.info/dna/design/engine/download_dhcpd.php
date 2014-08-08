# dhcpd.conf (part)
# Generator: <?=SOFTWARE_LONGNAME?> <?=SOFTWARE_VERSION?>

# https://<?=getenv("SERVER_NAME").":".getenv("SERVER_PORT").getenv("REQUEST_URI")?>

<? if($output!=""){ ?># <?=$output?><? } ?>
subnet <?=$dhcpd->NetBase?> netmask <?=NumberToIP(CalcIPMask($dhcpd->NetMaskWidth))?> {
<? if($dhcpd->DefaultLeaseTime!=0){ ?>
	default-lease-time <?=$dhcpd->DefaultLeaseTime?>;
<? } ?>
<? if($dhcpd->MaxLeaseTime!=0){ ?>
	max-lease-time  <?=$dhcpd->MaxLeaseTime?>;
<? } ?>
	option domain-name-servers <?=$dhcpd->NameServers?>;
<? if($dhcpd->DefaultDomain!=""){ ?>
	option domain-name "<?=$dhcpd->DefaultDomain?>";
<? } ?>
	option routers <?=$dhcpd->GatewayIP?>;
	option broadcast-address <?=NumberToIP($ipbroadcast)?>;
<?
	$lastip="";
	for($i=0;$i<count($computers);$i++){
		$c=$computers[$i];
		if($c->IP!=$lastip){
?>
	host <?=$c->NameBegin?> { hardware ethernet <?=HWAddr_AddColons($c->HWAddr)?>; fixed-address <?=$c->IP?>; }
<?
		}
		$lastip=$c->IP;
	}
?>
}
