;
; Bind zone file
; Generator: <?=SOFTWARE_LONGNAME?> <?=SOFTWARE_VERSION?>

; https://<?=getenv("SERVER_NAME").":".getenv("SERVER_PORT").getenv("REQUEST_URI")?>

<? if($output!="") echo("; OUTPUT=".$output);?>
;
$TTL <?=$domain->TTL?>

@ IN SOA <?=$domain->SOAServer?>. <?=$domain->SOAEmail?>. (
                            <?=$modifyd_day?><?=PreZero($domain->SOASerial,2)?> ; Serial
                            <?=$domain->SOARefresh?> ; Refresh
                            <?=$domain->SOARetry?> ; Retry
                            <?=$domain->SOAExpire?> ; Expire
                            <?=$domain->SOANegTTL?> ) ; Negative Cache TTL
;
; Static text from administrator:
;

<?=$domain->Text?>


;
; Computers:
;

<? for($i=0;$i<count($computers);$i++){ $c=$computers[$i] ?>
<?=$c->IPEnd?>	IN PTR	<?=$c->Name?>. ; <?=$c->HWAddr?>

<? } ?>
