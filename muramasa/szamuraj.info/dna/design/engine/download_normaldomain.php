;
; Bind zone file
; Generator: <?=SOFTWARE_LONGNAME?> <?=SOFTWARE_VERSION?>

; https://<?=getenv("SERVER_NAME").":".getenv("SERVER_PORT").getenv("REQUEST_URI")?>

<? if($output!="") echo("; OUTPUT=".$output);?>
;
$TTL <?=$domain->TTL?>

<?=$domain->NameEnd?>. IN SOA <?=$domain->SOAServer?>. <?=$domain->SOAEmail?>. (
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
; CNAMEs from database
;

<? for($i=0;$i<count($cnames);$i++){ ?>
<?=$cnames[$i]->NameBegin1?>	IN CNAME	<?=$cnames[$i]->Target?>	<? if($cnames[$i]->Descr!=""){ ?>; <?=strtr($cnames[$i]->Descr,"\r\n","  ")?><? } ?>

<? } ?>

;
; Computers:
;

<? for($i=0;$i<count($computers);$i++){ $c=$computers[$i] ?>
<?=$c->NameBegin?>	IN A	<?=$c->IP?> ; A/1234 X Y <?=$c->HWAddr?>

<? } ?>
