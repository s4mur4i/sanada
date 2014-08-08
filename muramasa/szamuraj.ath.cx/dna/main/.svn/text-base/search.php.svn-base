<?
	if(HasRights("READ")!=1){
		$result.="Nincs megfelelő jogosultságod.".BR;
		AfterPost("index.php?mode=home");
		return;
	}
	require_once("engine/computers_search.php");
	switch($func){
		case "search":
		case "search_mail":
		case "trysearch_mail": {
			$orderby=floor(REQV("orderby",0)+0);
			$print=REQV("print",0)?1:0;
			$ban=floor(REQV("ban",REQC("cook_search_ban",-1))+0);
			$validitystate=floor(REQV("validitystate",REQC("cook_search_validitystate",-1))+0);
			$accessclass=floor(REQV("accessclass",REQC("cook_search_accessclass",-1))+0);
			$custom_reftime=floor(REQV("custom_reftime",REQC("cook_search_custom_reftime",0))+0);
			$reftime=REQV("reftime",REQC("cook_search_reftime",""));
			$search=REQV("search",REQC("cook_search_string",".*"));
			$orderby=floor(REQV("orderby",REQC("cook_search_orderby",-1))+0);
			if(!isset($orderby)) $orderby=$cook_search_order;

			if(!in_array($accessclass,array(-1,ACCESSCLASS_PROTECTED,ACCESSCLASS_ADVANCED,ACCESSCLASS_SERVER,ACCESSCLASS_CUSTOM)))
				$accessclass=-1;
			if(!in_array($validitystate,array(-1,VALIDITYSTATE_VALID,VALIDITYSTATE_INVALID,VALIDITYSTATE_FOREVER)))
				$validitystate=-1;
			if(!in_array($ban,array(-1,0,1)))
				$ban=-1;
			if($custom_reftime!=1)
				$custom_reftime=0;
			if($custom_reftime==1){
				if($reftime=="")
					$reftime=StampToDateTime(TIME);
			} else
				$reftime=StampToDateTime(TIME);
			$reftimed=MyDateToStamp($sock,$reftime);
			if($reftimed==0)
				$reftimed=MyDateToStamp($sock,TIME);
			$reftime=StampToDateTime($reftimed);

			if($orderby<0 || $orderby>=count($orders))
				$orderby=0;
			if($search!=".*" || $validitystate!=-1 || $ban!=-1 || $accessclass!=-1
					|| isset($ok) || $func=="search_mail" || $func=="trysearch_mail")
				$do_search=1;
			else
				$do_search=0;
			if($search=="")
				$search=".*";
			if($do_search==1){
				$computers=SearchComputers($sock,$search,$orders[$orderby]->SQL,$ban,$validitystate,$reftimed,$accessclass);
			} else {
				$search="";
			}
			setcookie("cook_search_string",$search,TIME+1800,"/");
			setcookie("cook_search_ban",$ban,TIME+1800,"/");
			setcookie("cook_search_validitystate",$validitystate,TIME+1800,"/");
			setcookie("cook_search_accessclass",$accessclass,TIME+1800,"/");
			setcookie("cook_search_order",$orderby,TIME+1800,"/");
			setcookie("cook_search_custom_reftime",$custom_reftime,TIME+1800,"/");
			setcookie("cook_search_reftime",$reftime,TIME+1800,"/");
			
			if($func=="search_mail" || $func=="trysearch_mail"){
				$subject=trim(REQV("subject",""));
				require_once("engine/roots_common.php");
				if(HasRights("NEWSLETTERADMIN",$user)!=1){
					$result.=TEXT_M_noaccess.BR;
					AfterPost("index.php?mode=home");
					return;
				}
				$roots=ReadRootsByComputers($sock,$computers);
			}
			if($func=="trysearch_mail"){
				$body=rtrim(REQV("body",""));
				if($subject=="")
					$result.="Nincs megadva tárgy.".BR;
				if($body=="")
					$result.="Nincs megadva szöveg.".BR;
				if($result==""){
					sys_log("SEND: ".$user->Email.", subj: '".$subject."'");
					sys_log("SEND: BODY BEGIN");
					sys_log($body);
					sys_log("SEND: BODY END");
					$output.="Tárgy: ".ToHTML($subject).BR;
					$output.="<HR>";
					$output.=nl2br(ToHTML($body));
					$output.="<HR>";
					$output.="<I>Elküldve a következőknek:</I>".BR;
					if($body!=""){
						$domainid=floor(REQV("domainid",0)+0);
//						header("Content-Type: text/plain; charset=UTF-8");
//						var_dump($roots);
//						exit();
//						$nil->RealName="Darabos Edvárd Konrád";
//						$nil->Email="nil@hippy.csoma.elte.hu";
//						$roots=array($nil);
						$email=new stdClass;
						$email->Subject="[CSOMANET-ERTESITO] ".$subject;
						$email->ReplyTo="Szalai Imre <simre@csoma.elte.hu>, Vitaforum a kollegium halozatarol <kszk-l@csoma.elte.hu>";
						foreach($roots as $row){
							// $email->To="nil@hippy.csoma.elte.hu";
							if($row->RealName=="") $row->RealName="Nevtelen";
							$email->To=addslashes($row->RealName." <".$row->Email.">");
							$email->Text="";
							$email->Text.="Kedves ".$row->RealName.", számítógép üzemeltető!\n\n";
							$email->Text.=$body."\n\n";
							$email->Text.="KCSSK Hálózati Adminisztrátorok\n";
							$email->Text.="------------------------------------------------------------\n";
							$email->Text.="Ez egy KCSSK CSOMANET hírlevél. Tartalma illetve a benne lévő\n";
							$email->Text.="esetleges felszólítások nem minden esetben vonazkoznak rád.\n";
							SendPlainEmail($email);
							$output.=ToHTML($row->RealName)." &lt;".$row->Email."&gt;".BR;
						}
						$output.=BR;
						$output.="<A href='index.php?mode=home'>Nyitóoldalra</A>".BR;
						$mode="blank";
					}
				} else $func="search_mail";
			}
		} break;
		default:{
			$result.="Érvénytelen funkció '".ToHTML($mode)."' / '".ToHTML($func)."'".BR;
			$mode="blank";
		} break;
	}
?>
