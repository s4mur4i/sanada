<?
	if($user->LIN){
		echo("<TABLE border=0 cellpadding=2 cellspacing=2 width=150>\n");
		putmenu("","Nyitóoldal","index.php?mode=home");
		putmenu("","Saját adatok","index.php?mode=useradmin&func=modifyself");
		putmenu("READ|USERADMIN","Rendszer beállítások","index.php?mode=variables");
		putmenu("","---","#");
		putmenu("USERADMIN","Felhasználók","index.php?mode=useradmin&func=users");
		putmenu("USERADMIN","Új felhasználó","index.php?mode=useradmin&func=newuser");
		putmenu("USERADMIN","---","#");
		putmenu("READ|DOMAINADMIN","Domain-ek","index.php?mode=domainadmin&func=domains");
		putmenu("READ|DOMAINADMIN","Tiltott hálók","index.php?mode=deniednetadmin&func=deniednets");
		putmenu("READ|DOMAINADMIN","---","#");
		putmenu("READ|COMPUTERADMIN","Keresés","index.php?mode=search&func=search");
		putmenu("COMPUTERADMIN","Új gép","index.php?mode=computeradmin&func=newcomputer");
		putmenu("COMPUTERADMIN","Befizetések","index.php?mode=masspaymentadmin&func=paymenu");
		putmenu("COMPUTERADMIN","Rendszergazdák","index.php?mode=rootadmin&func=roots");
		putmenu("READ|COMPUTERADMIN","---","#");
		putmenu("READ|COMPUTERADMIN","Letiltás napló","index.php?mode=viewlog&func=banlog");
		putmenu("READ|COMPUTERADMIN","Rendszer napló","index.php?mode=viewlog&func=syslog");
		putmenu("READ|COMPUTERADMIN","---","#");
		putmenu("NEWSLETTERADMIN","Hírlevél küldés","index.php?mode=newsletter&func=sendmessage");
		putmenu("NEWSLETTERADMIN","---","#");
		putmenu("","Kilépés","index.php?mode=logout");
		echo("<TR><TD align='center'>");
		echo("<BR>\n");
		echo("<A href='index.php?mode=about' style='text-decoration: none'>".SOFTWARE_SHORTNAME." <SPAN class='good'>".SOFTWARE_VERSION."</SPAN></A><BR>");
		echo(SOFTWARE_EDITION."<BR>\n");
		echo(StampToDateTime(TIME)."<BR>\n");
		echo("</TD></TR>\n");
		echo("</TABLE>");
	}
//----------------------------------------------------------
	function putmenu($right,$str,$url,$target="")
	{
		global $user;
		if(HasRights($right,$user)){
			if($str=="---"){
				echo("<TR><TD></TD></TR>\n");
			} else {
				if($target) $target=" target='".$target."'";
				echo("<TR><TD class='menu'><A class='menu' href='".$url."'".$target.">".$str."</A></TD></TR>\n");
			}
		}
	}
?>
