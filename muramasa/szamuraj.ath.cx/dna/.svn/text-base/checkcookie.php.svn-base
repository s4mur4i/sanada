<?
	require("engine/header.macro.php");
	require("engine/sessions.php");
	if(REQC(SIDNAME,"")!="" && REQV("origin","")!=""){
		HTTPRedirect(REQV("origin"));
	}
?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=UTF=8' />
<title>Nincs cookie támogatás</title>
</head>
<body>
<h2>A böngésződ nem támogatja a cookie-kat.</h2>
<p>Az oldal csak cookie-val működik, a cookie, amit elküld a böngésződnek a következő:</p>
<table border=1><tr><td align=right>Neve:</td><td><?=SIDNAME?></td></tr>
<tr><td align=right>Típusa:</td><td>egész</td></tr>
<tr><td align=right>Értéke:</td><td><?=REQV("cookie")?></td></tr>
</table>
</body>
</html>
