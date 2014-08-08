<?
	require("design/engine/default_header.php");
	switch($mode){
		case "home":
		case "login":{
			require("design/engine/index_".$mode.".php"); break;
		} break;

		case "useradmin":
		case "variables":
		case "rootadmin":
		case "domainadmin":
		case "deniednetadmin":
		case "masspaymentadmin":
		case "search":
		case "computeradmin":
		case "viewlog":
		case "newsletter":{
			require("design/engine/".$mode."_".$func.".php"); break;
		} break;

		case "about":
		case "hacker":
		case "abort":
		case "blank":
		case "jump":{
			require("design/engine/default_".$mode.".php");
		} break;
		default:{
			$result.="PROGRAMMER ERROR: Unhandled mode at design stage: ".ToHTML($mode)."<BR>";
			require("design/engine/default_blank.php");
		} break;
	}
	require("design/engine/default_footer.php");
?>
