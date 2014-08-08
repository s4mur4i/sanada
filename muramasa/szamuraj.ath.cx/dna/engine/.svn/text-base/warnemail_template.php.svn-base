<?
	// INPUT: computer structure named $computer
	// INPUT: $ttl: Time of validity in seconds
	// INPUT: $limit: Limit that is reached for warning, in seconds
?>
<p>Kedves <?=ToHTML($computer->RealName)?>, számítógép üzemeltető!</p>
<p style='margin-left: 30pt;'>Az Ön által üzemeltetett alábbi számítógép érvényessége hamarosan lejár.</p>
<table border=0 cellspacing=0 cellpadding=3 style='margin-left: 100px;'>
<tr><td align='right'>Számítógép:</td><td><?=ToHTML($computer->Name)?> (<?=$computer->IP?>)</td></tr>
<tr><td align='right'>Érvényesség lejárta:</td><td><?=StampToDateTime($computer->ValidUntilD)?></td></tr>
<tr><td align='right'>Hátralévő idő:</td><td><?=ToHTML(SecstoTime($ttl,"nap","óra","perc","másodperc","semennyi"))?></td></tr>
</table>
<p style='margin-left: 30pt;'>Ez az automatizált tájékoztatás összesen 3
alkalommal kerül kiküldésre: hozzávetőleg 7, 3 és 1 nappal az érvényesség
lejárta előtt. Ha a továbbiakban nem tart igényt ezen jogosultságára, akkor
kérjük hagyja figyelmen kívül leveleinket!</p>
<p>Üdvözlettel: KCSSK Hálózati Adminisztrátorok</p>
