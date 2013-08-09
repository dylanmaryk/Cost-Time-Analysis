<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 'on');
	$start = urlencode($_GET['name_origin']);
	$end   = urlencode($_GET['name_destination']);
	$included = $_GET['includedMeans'];
	$includedstring = "";
	$i = 0;
	while(true) {
		if ($i < count($included) - 2) {
			$includedstring .= $included[$i] . ",";
		} else {
			$includedstring .= $included[$i];
			break;
		}
		$i++;
	}
	echo file_get_contents("xml/$start-$end-$includedstring.php");
?>
