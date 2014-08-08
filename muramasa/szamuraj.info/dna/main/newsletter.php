<?
	require_once("engine/domains_common.php");
	require_once("engine/roots_common.php");
	switch($func){
		case "sendmessage":
		case "trysendmessage":{
			if(HasRights("NEWSLETTERADMIN",$user)==1){
				$subject=trim(REQV("subject",""));
				$body=trim(REQV("body",""));
				$domainid=floor(REQV("domainid",0)+0);
				if($func=="trysendmessage"){
					if($subject=="") $result.="Nincs megadva Tárgy.".BR;
					if($body=="") $result.="Nincs megadva szöveg.".BR;
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
							$roots=ReadRootsByDomain($sock,$domainid);
//							$nil->RealName="Darabos Edvárd Konrád";
//							$nil->Email="nil@hippy.csoma.elte.hu";
//							$roots=array($nil);
							$email->Subject=addslashes("[CSOMANET-HIRLEVEL] ".$subject);
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
					} else $func="sendmessage";
				}
				if($func=="sendmessage"){
					$domains=ReadDomains($sock,0); // all
				}
			} else {
				$result.="Szükséges jogosultság hiányzik.".BR;
				AfterPost("index.php?mode=home");
			}
		} break;
		default:{
			$result.="Érvénytelen funkció '".ToHTML($mode)."' / '".ToHTML($func)."'".BR;
			$mode="blank";
		} break;
	}
?>
