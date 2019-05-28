<?php
$pagename = str_replace(array('/', '.php', '?s='), '', $_SERVER['REQUEST_URI']);
$pagename = str_replace("wp", '', $_SERVER['REQUEST_URI']);
$pagename = $pagename ? $pagename : 'default';

switch ($pagename) {
    case "aboutus":
		$titlepage = "About us title";
		$desPage = "";
		$keyPage = "";
		$txtH1 = "H1 content for about us";
	break;
	 
    default:
		$titlepage = "Default";			
		$desPage = "";
		$keyPage = "";
		$txtH1 = "H1 Default";
}
?>