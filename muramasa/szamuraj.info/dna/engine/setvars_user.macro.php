<?
	if(isset($luser)){
		$nick=$luser->Nick;
		$pass="";
		$realname=$luser->RealName;
		$email=$luser->Email;
		$rights=$luser->Rights;
	} else {
		$nick=REQV("nick","");
		$pass=REQV("pass","");
		$realname=REQV("realname","");
		$email=REQV("email","");
		$rights=REQV("rights","");
	}
?>
