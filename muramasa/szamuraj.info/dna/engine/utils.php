<?
	define("FILE_COMMAND","/usr/bin/file");
//----------------------------------------------------------
	function isSubStr($s0,$s){
		if(strpos($s0,$s).""!="") $ret=1;
		else $ret=0;
		return($ret);
	}
//----------------------------------------------------------
	// Convert a string to quoted-prinable format. Example:
	// Call: ToQuotedPrintable("ISO-8859-2","Darabos Edvárd Konrád")
	// Return: "=?ISO-8859-2?Q?Darabos=20Edv=E1rd=20Konr=E1d?="
	function ToQuotedPrintable($charset,$s){
		if($s!="")
			return mb_encode_mimeheader($s, $charset, "Q");
		return "";
	}
//----------------------------------------------------------
	function ToHTML($s){
		$s.="";
		$s=stripslashes($s);
		$ret="";$len=strlen($s);
		for($i=0;$i<$len;$i++){
			$c=$s[$i];
			if($c=="&") $c="&amp;";
			if($c=="<") $c="&lt;";
			if($c==">") $c="&gt;";
			if($c=="'") $c="&#39;";
			if($c=="\"") $c="&quot;";
			$ret.=$c;
		}
		return($ret);
	}
//----------------------------------------------------------
	function SingleSpace($s){
		$n=strlen($s);$v=0;
		$s2="";
		for($i=0;$i<$n;$i++){
			$c=$s[$i];
			if($c==" "){
				if($v==1) $c="";
				$v=1;
			} else $v=0;
			$s2.=$c;
		}
		return($s2);
	}
//----------------------------------------------------------
	function ResToDim($res){
		$n=db_num_rows($res);
		for($i=0;$i<$n;$i++) $dim[]=db_fetch_object($res);
		return($dim);
	}
//----------------------------------------------------------
	function ResToDim_Free($res){
		$n=db_num_rows($res);
		$dim=array();
		for($i=0;$i<$n;$i++)
			$dim[] = db_fetch_object($res);
		db_free_result($res);
		return($dim);
	}
//----------------------------------------------------------
	function inList($list,$item){
		$ret=0;
		if(strpos($list,",".$item.",").""!="") $ret=1;
		return($ret);
	}
//----------------------------------------------------------
	function ListAddDel($list,$adds,$dels){
		$oldcats=$list;
		$s2=",";$tmp=""; //----- Del section
		for($i=0;$i<strlen($oldcats);$i++){
			if($oldcats[$i]==","){
				if($tmp!=""){
					if(strpos($dels,",".$tmp.",").""=="") $s2=$s2.$tmp.",";
					$tmp="";
				}
			} else $tmp=$tmp.$oldcats[$i];
		}
		$dummy=explode(",",$adds);
		for($i=0;$i<count($dummy);$i++){
			if($dummy[$i]!="" && inList($s2,$dummy[$i])==0)$s2=$s2.$dummy[$i].","; //----- Add
		}
		return($s2);
	}
//----------------------------------------------------------
	function StampToDateTime($time){
		if($time!=0)
			return date("Y-m-d H:i:s",$time);
		return "-";
	}
//----------------------------------------------------------
	function StampToTime($time){
		$ret=date("H:i:s",$time);
		return($ret);
	}
//----------------------------------------------------------
	function StampToDate($time){
		$ret=date("Y-m-d",$time);
		return($ret);
	}
//----------------------------------------------------------
	function SecsToTime($time,$daysname="day(s)",$hoursname="hour(s)",$minsname="minute(s)",$secondsname="second(s)",$nothing="nothing")
	{
		$min = 1 * 60;
		$hour = $min * 60;
		$day = $hour * 24;
		$ret = "";
		$t = $time;

		if($t >= $day){
			if($ret!="")
				$ret.=" ";
			$ret .= round($t/$day)." ".$daysname;
			$t %= $day;
			if($t==0)
				return $ret;
		}

		if($ret!="" || $t >= $hour){
			if($ret!="")
				$ret.=" ";
			$ret .= round($t/$hour)." ".$hoursname;
			$t %= $hour;
			if($t==0)
				return $ret;
		}

		if($ret!="" || $t >= $min){
			if($ret!="")
				$ret.=" ";
			$ret .= round($t/$min)." ".$minsname;
			$t %= $min;
			if($t==0)
				return $ret;
		}

		if($ret!="" || $t >= 1){
			if($ret!="")
				$ret.=" ";
			$ret .= $t." ".$secondsname;
			return $ret;
		}
		
		return $nothing;
	}
//----------------------------------------------------------
	function MimeOf($fn){
		$mime="";
		for($i=-5;$i<0 && substr($fn,$i,1)!=".";$i++) {};
		if($i<-1){
		    $i++;
		    $ext=substr($fn,$i);
		    $f=fopen("/etc/mime.types","r");
		    while(!feof($f) && $mime==""){
				$line=fgets($f,1024);
				$line=str_replace("\t"," ",$line);
				while(strlen($line)>strlen(str_replace("  "," ",$line))){
				    $line=str_replace("  "," ",$line);
				}
				$d=explode(" ",$line);
				for($i=1;$i<count($d);$i++){
				    if(trim($d[$i])==trim($ext)) $mime=$d[0];
				}
				$line=substr($line,0,-1);
		    }
		    fclose($f);
		}
		return($mime);
	}
//----------------------------------------------------------
	function FileMimeOf($fn){
		$p=popen(FILE_COMMAND." -bi ".$fn,"r");
		$line=fgets($p,1024);
		$line=substr($line,0,-1);
		pclose($p);
		return($line);
	}
//----------------------------------------------------------
	function CatFile($fn){
		$f=fopen($fn,"rb");
		$content=fread($f,filesize($fn));
		fclose($f);
		echo($content);
	}
//----------------------------------------------------------
	function StringFilter($str,$good){ // Only the characters in $good are acceptable
		$ret=1;
		if(strlen($str)==0) $ret=0;
		$lcs=strlen($str);$lg=strlen($good);
		for($i=0;$i<$lcs && $ret==1;$i++){
			$c=$str[$i];$x=0;
			for($j=0;$j<$lg && $x==0;$j++) if($good[$j]==$c) $x=1;
			if($x==0) $ret=0;
		}
		return($ret);
	}
//----------------------------------------------------------
	function PreZero($x,$w){
		$s=$x."";
		while(strlen($s)<$w) $s="0".$s;
		return($s);
	}
//----------------------------------------------------------
	function ToURL($url){
		$url=rawurlencode($url);
		if(substr($url,-3)=="%0A") $url=substr($url,0,-3);
		return($url);
	}
//----------------------------------------------------------
	function SendPlainEmail($mail,$logging=1){
		global $FUNC,$LANG;
		$mail = clone $mail;
		$charset=CFG_DEFAULT_CHARSET;
		$FUNC="SendPlainEmail";
		if(trim($mail->To)=="") return;
		if(!isset($mail->From) || $mail->From==""){
			$mail->From=ToQuotedPrintable($charset,CFG_SYSTEM_SENDERNAME)." <".CFG_SYSTEM_EMAIL.">";
		} else {
			// Format "From" field.
			$tmp=explode("<",$mail->From);
			if(count($tmp)>1 && strlen($tmp[0])>0){
				$fromname=$tmp[0];
				$tmp=explode(">",$tmp[1]);
				$fromaddr=$tmp[0];
				$mail->From=ToQuotedPrintable($charset,$fromname)." <".$fromaddr.">";
			}
		}
		// Format "To" field
		$tmp=explode("<",$mail->To);
		if(count($tmp)>1 && strlen($tmp[0])>0){
			$toname=$tmp[0];
			$tmp=explode(">",$tmp[1]);
			$toaddr=$tmp[0];
			$mail->To=ToQuotedPrintable($charset,$toname)." <".$toaddr.">";
		}
		
		$mail->ReturnPath="<".CFG_SYSTEM_EMAIL.">";
		if($mail->Subject=="")
			$mail->Subject=ToQuotedPrintable($charset,"[".CFG_SITENAME."]");
		else
			$mail->Subject=ToQuotedPrintable($charset,$mail->Subject);

		// Generate message ID
		$tmp=microtime();
		$tmp=explode(" ",$tmp);
		$idpart1=substr(md5($tmp[1]),0,16);
		$idpart2=substr(md5($tmp[1]+1),0,16);
		$mail->MessageID=$idpart1."-".$idpart2."-".CFG_SYSTEM_EMAIL;
		$_simulate = defined(EMAIL_SIMULATE_ONLY) && strtolower(EMAIL_SIMULATE_ONLY)=="true";

		if($logging==1)
			sys_log("INFO:".($_simulate?" [Not really]":"")." Sending message to '".$mail->To."' subj='".$mail->Subject."'");
		if($_simulate)
			$f=fopen("private/dna-last-sent-email.txt","w");
		else
			$f=popen(MAILERCMD." -f \"".addslashes(CFG_SYSTEM_EMAIL)."\"","w");
		fputs($f,"Return-Path: ".$mail->ReturnPath."\n");
		fputs($f,"From: ".$mail->From."\n");
		fputs($f,"To: ".$mail->To."\n");
		fputs($f,"Subject: ".$mail->Subject."\n");
		fputs($f,"Message-Id: <".$mail->MessageID.">\n");
		if($mail->ReplyTo!="")
			fputs($f,"Reply-To: ".$mail->ReplyTo."\n");
		else
			fputs($f,"Reply-To: ".$mail->From."\n");
		if(isset($mail->Cc) && $mail->Cc!="")
			fputs($f,"Cc: ".$mail->Cc."\n");
		if(isset($mail->Bcc) && $mail->Bcc!="")
			fputs($f,"Bcc: ".$mail->Cc."\n");
		if(!isset($mail->MimeType) || $mail->MimeType=="")
			$mail->MimeType="text/plain; charset=".$charset."\n";
		elseif(isset($mail->MimeType) && $mail->MimeType=="text/html")
			$mail->MimeType.="; charset=".$charset."\n";
		fputs($f,"MIME-Version: 1.0\n");
		if(isset($mail->isMultipartAlternative) && $mail->isMultipartAlternative){
			$boundary="===";
			for($i=0;$i<count($mail->parts);$i++){
				$boundary.=substr(md5($mail->parts[$i]->Text),-8);
			}
			fputs($f,"Content-Type: multipart/alternative;\n");
			fputs($f," boundary=\"".$boundary."\"\n");
			fputs($f,"\n");
			fputs($f,"This is a multi-part message in MIME format.\n");
			fputs($f,"--".$boundary."\n");
			for($i=0;$i<count($mail->parts);$i++){
				fputs($f,"Content-Type: ".$mail->parts[$i]->MimeType."; format=flowed\n");
				fputs($f,"Content-Transfer-Encoding: 8bit\n");
				fputs($f,"Content-Length: ".strlen($mail->parts[$i]->Text)."\n");
				fputs($f,"\n");
				fputs($f,$mail->parts[$i]->Text);
//				if(substr($mail->parts[$i]->Text,-1)!="\r" && substr($mail->parts[$i]->Text,-1)!="\n") // is it required?
					fputs($f,"\n");
				fputs($f,"--".$boundary."\n");
			}
		} else {
			fputs($f,"Content-Type: ".$mail->MimeType."\n");
			fputs($f,"\n".$mail->Text);
		}
		pclose($f);
	}
//----------------------------------------------------------
	function HTMLToText(&$html,$charset="UTF-8"){
		// #1: lynx -dump -force_html
		$tmp_in=tempnam(null,"html-to-searchable-text-input-");
		$tmp_out=tempnam(null,"html-to-searchable-text-output-");
		$f=fopen($tmp_in,"w");
		fwrite($f,$html,strlen($html));
		fclose($f);
		$text="";
		//
		$cmd="lynx -dump -force_html  -assume_charset=".$charset." -display_charset=".$charset." \"".$tmp_in."\" > \"".$tmp_out."\"";
		// echo("DEBUG: cmd: ".$cmd."\n");
		system($cmd);
		$text=file_get_contents($tmp_out);
		unlink($tmp_in);
		unlink($tmp_out);

		return $text;
	}
//----------------------------------------------------------
	function IPToNumber($ip){
		$ipns=explode(".",$ip);
		$ipvalue=$ipns[0]*256*256*256+$ipns[1]*256*256+$ipns[2]*256+$ipns[3];
		return($ipvalue);
	}
//----------------------------------------------------------
	function NumberToIP($ipvalue){
		$ip=($ipvalue&(pow(2,31)+pow(2,30)+pow(2,29)+pow(2,28)+pow(2,27)+pow(2,26)+pow(2,25)+pow(2,24)))/pow(2,24);
		if($ip<0) $ip+=256;
		$ip.=".";
		$ip.=($ipvalue&(pow(2,23)+pow(2,22)+pow(2,21)+pow(2,20)+pow(2,19)+pow(2,18)+pow(2,17)+pow(2,16)))/pow(2,16);
		$ip.=".";
		$ip.=($ipvalue&(pow(2,15)+pow(2,14)+pow(2,13)+pow(2,12)+pow(2,11)+pow(2,10)+pow(2,9)+pow(2,8)))/pow(2,8);
		$ip.=".";
		$ip.=$ipvalue&(pow(2,7)+pow(2,6)+pow(2,5)+pow(2,4)+pow(2,3)+pow(2,2)+pow(2,1)+pow(2,0));
		return($ip);
	}
//----------------------------------------------------------
	function CalcIPMask($maskwidth){
		$ipmask=0;
		for($i=0;$i<$maskwidth;$i++){
			$ipmask+=pow(2,(31-$i));
		}
		return($ipmask);
	}
//----------------------------------------------------------
	function HWAddr_AddColons($hwaddr){
		return(substr($hwaddr,0,2).":".substr($hwaddr,2,2).":".substr($hwaddr,4,2).":".substr($hwaddr,6,2).":".substr($hwaddr,8,2).":".substr($hwaddr,10,2));
	}
?>
