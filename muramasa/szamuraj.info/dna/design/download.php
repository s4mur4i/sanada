<?
	switch($mode){
		case "noauth":{
			header("HTTP/1.0 401 Unauthorized");
			header("WWW-Authenticate: Basic realm=\"".SOFTWARE_SHORTNAME." export\"");
			header("Content-type: text/plain; charset=UTF-8");
			header("X-Generator: ".SOFTWARE_LONGNAME." ".SOFTWARE_VERSION);
			require("design/engine/download_noauth.php");
		} break;
		case "deniednets":
		case "normaldomain": case "reversedomain":
		case "dhcpd": case "roots": case "roots2":
		case "staticarp": case "staticarpac": case "staticarpacb":
		case "staticarphost": case "weblist": case "weblist2": {
			header("Content-Type: text/plain; charset=UTF-8");
			if(isset($domain) && is_object($domain)){
				$gmt_modified=gmdate("D, d M Y H:i:s",$domain->ModifyD)." GMT";
				header("Last-Modified: ".$gmt_modified);
				if(getenv("HTTP_IF_MODIFIED_SINCE")!=$gmt_modified)
				{
					ob_start();
					require("design/engine/download_".$mode.".php");
					header("X-MD5Sum: ",md5(ob_get_contents()));
					ob_end_flush();
				} else
					header("HTTP/1.1 304 Not Modified");
			} else {
				ob_start();
				require("design/engine/download_".$mode.".php");
				header("X-MD5Sum: ".md5(ob_get_contents()));
				ob_end_flush();
			}
		} break;
		case "static":{
			header("Content-type: text/plain; charset=UTF-8");
			require("design/engine/download_static.php");
		} break;
		case "abort":{
			header("HTTP/1.0 404 Not found");
			header("Content-type: text/plain; charset=UTF-8");
			require("design/engine/download_abort.php");
		} break;
		default: echo("PROGRAMMER ERROR: Invalid 'mode' at stage 2: '".$mode."'"); break;
	}
?>
