<?php
	define("APP_URL", "http://teddycoder.com/projects/navicontrol/");
	define("APP_PATH", "/home/teddycoder/public_html/projects/navicontrol/");
	define("APP_PATH", "/home/teddycoder/public_html/projects/navicontrol/");
	
	function getArrUrl($var)
	  {
			$nvar = Array();
			$na = explode("/", $var);
			for($i=0; $i<count($na)-1;$i+=4)
			{
				$nvar["$na[$i]"] = $na[$i+1];
			}
			return $nvar;
	  }
	
	  $args = getArrUrl($_GET['args']);
?>


