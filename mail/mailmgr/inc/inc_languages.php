<?php
	//-------------------------------------
	// Language selection
	function CreateLanguageSwitch($ActLang, $Style, $Style2)
	{
		$LangSwitch = "";
		$Contents = array();
		$query 	  = "SELECT * FROM languages WHERE active=1";
		$Set      = sql($query, "select");
		for($i = 0; $i < count($Set); $i++)
		{
			$id = $Set[$i]["id"];
			$te = $Set[$i]["name"];
			if($ActLang == $id)
				$LangSwitch .= "<span class='$Style2'><strong>$te</strong></span>&nbsp;&nbsp;";
			else
				$LangSwitch .= "<span class='$Style2'><a href='#' onclick='ChangeLanguage($id)' class='$Style'>$te</a></span>&nbsp;&nbsp;";
		}
		return $LangSwitch;
	}
	$Switches = CreateLanguageSwitch($grs_app_lang, "white", "f10white");
?>
<?php echo $Switches?>

