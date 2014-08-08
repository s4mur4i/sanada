<?
	$FUNC="checkdata_user.macro";
	$nick=trim(REQV("nick",""));
	$pass1=REQV("pass1","");
	$pass2=REQV("pass2","");
	$email=trim(REQV("email",""));
	$realname=trim(REQV("realname",""));
	$luserid+=0;

	if(strlen($nick)<3) $result.="<BR>Az azonosítónak legalább 3 betűnek kell lennie."; //Nick syntax
	else {
		if(isSubStr($nick," ")!=0) $result.="<BR>Az azonosítóban nem szerepelhet szóköz.";
		if(strlen($nick)>16) $result.="<BR>Az azonosító maximum 16 karakter lehet.";
	}
	$q="select 1 from users where ID!=".$luserid." and Nick='".addslashes($nick)."';"; //Nick uniqueness
	$res=db_q($q,$sock,$FUNC.": searching nick");
	if(db_num_rows($res)!=0) $result.="<BR>Ilyen nevü harcosunk már van. Válassz másik azonosítót.";
	db_free_result($res);

	if($realname=="") $result.="<BR>Elfelejtetted megadni a valódi nevet."; // RealName syntax
	else {
		if(strlen($realname)<6) $result.="<BR>A névnek legalább 6 karakternek kell lennie.";
		if(isSubStr($realname," ")==0) $result.="<BR>A nevének tartalmaznia kell legalább egy szóközt.";
		if(SingleSpace($realname)!=$realname) $result.="<BR>A névben nem szerepelhet két szóköz egymás mellett.";
		if(strlen($realname)>64) $result.="<BR>A név maximum 64 karakter lehet.";
	}

	if($func=="trynewuser" || $pass1!="" || $pass2!=""){
		if(strlen($pass1)<4) $result.="<BR>A jelszónak legalább 4 karakternek kell lennie."; //Password length
		if($pass1!=$pass2) $result.="<BR>A jelszó és a megerősítése nem egyezik."; //Passwords compare
	}
	if($email=="") $result.="<BR>Nincs megadva email cím.";
	else {
		if(isSubStr($email,"@")==0) $result.="<BR>Nincsen kukac az email címben."; //Email syntax
		if(isSubStr($email,".")==0) $result.="<BR>Nincsen pont az email címben.";
		if(isSubStr($email," ")==1) $result.="<BR>Az emailcím nem tartalmazhat szóközt.";
		if(strlen($email)<6) $result.="<BR>Az emailcímnek legalább 6 karakternek kell lennie.";
		if(strlen($email)>128) $result.="<BR>Az emailcím maximum 128 karakter lehet.";
		
		$q="select 1 from users where ID!=".$luserid." and Email='".addslashes($email)."';"; //Email uniqueness
		$res=db_q($q,$sock,$FUNC.": searching email");
		if(db_num_rows($res)!=0) $result.="<BR>Ilyen emailcím már van az adatbázisunkban.";
		db_free_result($res);
	}
	
	//rights
	if($func!="trymodifyself"){
		$tmp=REQV("rights",array());
		$rights="";
		$n=0;
		for($i=0;$i<count($tmp);$i++){
			if($n>0) $rights.="+";
			$right=ReadRight($sock,$tmp[$i]);
			if(is_object($right)){
				$rights.=$right->ID;
				$n++;
			}
		}
	} else {
		$rights=$luser->Rights;
	}
?>
