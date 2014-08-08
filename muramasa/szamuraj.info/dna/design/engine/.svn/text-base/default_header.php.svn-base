<? require_once("design/engine/default_funcs.php"); ?>
<HTML>
<HEAD>
<TITLE>Domain Name Adminisztrator</TITLE>
<? if(isset($http_refresh_url) && $http_refresh_url!=""){ ?>
<META http-equiv='Refresh' content='<?=$http_refresh_time?>; url=<?=ToHTML($http_refresh_url)?>'>
<? } ?>
<META http-equiv='Cache-Control' content='no-cache'>
<META http-equiv='Content-Type' content='text/html; charset=UTF-8'>
<META name='Generator' value='<?=SOFTWARE_LONGNAME?> <?=SOFTWARE_VERSION?>'>
<META name='Owner' value='Eötvös Loránt Tudományegyetem, Kőrösi Csoma Sándor Kollégium'>
<META name='Author' value='Turdus and Nil'>
<LINK rel="shortcut icon" href="favicon.ico" type="image/vnd.microsoft.icon">
<LINK rel="icon" href="favicon.ico" type="image/vnd.microsoft.icon"> 
<? if(!isset($print) || $print!=1){ ?>
<LINK rel='stylesheet' type='text/css' href='design/include/style.css'>
<? } ?>
<LINK rel='stylesheet' type='text/css' href='design/include/source.css'>
</HEAD>
<?
	if(isset($print) && $print==1){
		echo("<BODY><CENTER><TABLE width=90% cellpadding=0 cellspacing=5><TR><TD>");
	} else {
?>
<BODY leftmargin=0 topmargin=0 rightmargin=0 marginheight=0 marginwidth=0 bottommargin=0>
<TABLE width=90% border=0 cellspacing=0 cellpadding=0 align='center' style='margin-top: 5px;'>
<TR><TD align='center'>
<A href='index.php?mode=about'><IMG src='design/images/dna.png' alt='<?=SOFTWARE_LONGNAME?>' title='<?=SOFTWARE_LONGNAME?> <?=SOFTWARE_VERSION?>' border=0></A><BR>
</TD></TR>
</TABLE>
<?
		if($user->LIN)
			echo("<TABLE border=0 cellspacing=0 cellpadding=3 width='90%'><TR><TD align='right'>Bejelentkezve: <B>".ToHTML($user->RealName)." (".ToHTML($user->Nick).")</TD></TR></TABLE>\n");
		if($skipmenu!=1){
			echo("<TABLE width='90%' border=0 cellspacing=0 cellpadding=10>\n");
			echo("<TR><TD align=center valign=top>");
			include("design/menu.php");
			echo("</TD><TD width=100% align=center valign=top>\n");
		}
		if($mode!="jump")
		{
			echo("<CENTER>");
			require("design/engine/default_last_result.php");
			echo("</CENTER>");
		}
	}
?>
