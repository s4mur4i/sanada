<?
	set_error_handler("sys_PHPError");
	if(ini_get("magic_quotes_gpc"))
		sys_Critical("magic_quotes_gpc is on, aborting");
	if(ini_get("register_globals"))
		sys_Critical("register_globals is on, aborting");
	define("BR","<br />\n");
	define("MAILERCMD","/usr/sbin/sendmail -t -i");
	$result="";
	$output="";
	umask(0002);

	if(isset($SERVER_NAME))
		$HTMLBASE=getenv("SERVER_NAME").":".getenv("SERVER_PORT").dirname($PHP_SELF);
	else
		$HTMLBASE="https://invalid.example/com/";
//----------------------------------------------------------
	function echoerr($text){
		fputs(STDERR,$text);
	}
//----------------------------------------------------------
	function sys_log($msg,$printerr=false){
		$f=fopen("private/log.txt","a+");
		$text=date("Y.m.d. H:i:s")." : ".$msg."\n";
		fputs($f,$text);
		fclose($f);
		if($printerr)
			echoerr($text);
	}
//----------------------------------------------------------
	function sys_Critical($msg){
		sys_log($msg,php_sapi_name()=="cli");
		if(php_sapi_name()!="cli"){
			header("HTTP/1.1 500 Internal Server Error");
			require("include/error.html");
		}
		exit();
	}
//----------------------------------------------------------
	function sys_PHPError($errno, $errmsg, $filename, $linenum, $vars){
		$critical_errors=array(E_ERROR,E_WARNING,E_PARSE,E_CORE_ERROR,E_CORE_WARNING,E_COMPILE_ERROR,E_COMPILE_WARNING,E_RECOVERABLE_ERROR);
		$is_critical=in_array($errno,$critical_errors);
		switch($errno){
			case 1: $level=" E_ERROR"; break;
			case 2: $level=" E_WARNING"; break;
			case 4: $level=" E_PARSE"; break;
			case 8: $level=" E_NOTICE"; break;
			case 16: $level=" E_CORE_ERROR"; break;
			case 32: $level=" E_CORE_WARNING"; break;
			case 64: $level=" E_COMPILE_ERROR"; break;
			case 128: $level=" E_COMPILE_WARNING"; break;
			case 256: $level=" E_USER_ERROR"; break;
			case 512: $level=" E_USER_WARNING"; break;
			case 1024: $level=" E_USER_NOTICE"; break;
			case 2048: $level=" E_STRICT"; break; // In the future.
			case 4096: $level=" E_RECOVERABLE_ERROR"; break;
			case 8192:  $level=" E_DEPRECATED"; break;
			case 16384: $level=" E_USER_DEPRECATED"; break;
			default: {
				$level.="UNKNOWN LEVEL (".$errno.")";
				$is_critical=true;
			} break;
		}
		if($errno!=E_STRICT)
			$is_critical=true;
		$msg="PHP script error: Level ".$level.": ".$filename." (".$linenum."): ".$errmsg;
		if($is_critical){
			sys_Critical($msg);
		} else {
			sys_log($msg,php_sapi_name()=="cli");
		}
	}
//----------------------------------------------------------
	function REQV($name,$default=NULL){
		if(isset($_GET[$name]))
			return $_GET[$name];
		if(isset($_POST[$name]))
			return $_POST[$name];
		return $default;
	}
//----------------------------------------------------------
	function REQC($name,$default=NULL){
		if(isset($_COOKIE[$name]))
			return $_COOKIE[$name];
		return $default;
	}
//----------------------------------------------------------
	function SRVV($name,$default=NULL){
		if(isset($_SERVER[$name]))
			return $_SERVER[$name];
		return $default;
	}
//----------------------------------------------------------
	function HTTPRedirect($url){
	    Header("HTTP/1.0 302 Found");
	    Header("Location: ".$url);
		echo("<HTML><HEAD><TITLE>Ugródeszka</TITLE>\n");
		echo("<meta http-equiv=refresh content='1; url=".$url."'>\n");
		echo("<BODY></BODY></HTML>\n");
	    exit();
	}
//----------------------------------------------------------
	function Refresh($url,$time=-1){
		global $output,$result;
		global $http_refresh_url,$http_refresh_time;
		if($time==-1){
			if($output!="" || $result!="") $time=round((strlen($output)+strlen($result))/15+0.5);
			else $time=0;
		}
		$http_refresh_url=$url;
		$http_refresh_time=$time;
	}
//----------------------------------------------------------
	function AfterPost($location)
	{
		global $mode,$output,$result,$last_result,$last_output;
		
//		sys_log("INPUT mode: ".$mode);
//		sys_log("INPUT last_result: ".$last_result);
//		sys_log("INPUT last_output: ".$last_output);
//		sys_log("INPUT result: ".$result);
//		sys_log("INPUT output: ".$output);
		
		if($last_output!="" && $output!="")
			$last_output.="<BR>";
		$last_output.=$output;
		if($last_result!="" && $result!="")
			$last_result.="<BR>";
		$last_result.=$result;
		
		$result="";
		$output="";
		
		$mode="jump";
		if(strpos($location,"?")===false)
			$location.="?";
		else
			$location.="&";
		$location.="last_result=".ToURL($last_result);
		$location.="&last_output=".ToURL($last_output);
		
//		sys_log("OUTPUT mode: ".$mode);
//		sys_log("OUTPUT last_result: ".$last_result);
//		sys_log("OUTPUT last_output: ".$last_output);
//		sys_log("OUTPUT result: ".$result);
//		sys_log("OUTPUT output: ".$output);
		
		Refresh($location,0);
	}
?>
