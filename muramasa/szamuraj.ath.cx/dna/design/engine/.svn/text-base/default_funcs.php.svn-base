<?
//----------------------------------------------------------
	function d_ColoredStampToDateTime($t,$t0=0,$largerclass="good",$smallerclass="danger"){
		if($t0==0) $t0=TIME;
		if($largerclass!="") $largerclass=" class='".ToHTML($largerclass)."'";
		if($smallerclass!="") $smallerclass=" class='".ToHTML($smallerclass)."'";
		if($t>$t0) $d_class=$largerclass;
		else $d_class=$smallerclass;;
		return "<SPAN".$d_class.">".StampToDateTime($t)."</SPAN>";
	}
?>
