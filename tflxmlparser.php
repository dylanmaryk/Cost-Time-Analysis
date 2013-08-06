<?php

// report all errors to page
error_reporting(E_ALL);
ini_set('display_errors', 'on');

$originpostcode = 'AL2 1AE';
$destinationpostcode = 'SW1H 0BD';
$safeorigin = urlencode($originpostcode);
$safedestination = urlencode($destinationpostcode);

$tflurlquery = 'http://journeyplanner.tfl.gov.uk/user/XML_TRIP_REQUEST2?language=en&place_origin=London&place_destination=London&type_origin=locator&name_origin=';
$tflurlquery .= $safeorigin;
$tflurlquery .= '&type_destination=locator&name_destination=';
$tflurlquery .= $safedestination;
// use if we want to allow future calculations
//$tflurlquery .= '&itdDate=' .$date. ' &itdTime=' $time;

$curl = curl_init();
curl_setopt_array($curl, array(
	CURLOPT_RETURNTRANSFER => 1,
	CURLOPT_URL => $tflurlquery,
	CURLOPT_USERAGENT => 'INSERT_DESCRIPTION_OF_SERVICE, INSERT_EMAIL_ADDRESS'
));

$xmlstring = curl_exec($curl);
//probably should check this
$responsecode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
//echo $xmlstring;
$xml = simplexml_load_string($xmlstring);
//var_dump($xml);
$routes = $xml->itdTripRequest->itdItinerary->itdRouteList;
//var_dump($routes);
//echo $routes->asXML();

// iterate through all the routes and print out the start and end times.
$i = 0;
foreach ($routes->itdRoute as $route) {
	$i++;
	$prl = $route->itdPartialRouteList;
	
	$startTime = $prl->itdPartialRoute->itdPoint->itdDateTime->itdTime;
	$startHour = $startTime['hour'];
	$startMinute = $startTime['minute'];
	
	$endpr = $prl->itdPartialRoute[count($prl->itdPartialRoute) - 1];
	$endTime = $endpr->itdPoint[count($endpr->itdPoint) - 1]->itdDateTime->itdTime;
	$endHour = $endTime['hour'];
	$endMinute = $endTime['minute'];
	
	//var_dump($endTime);
	//echo htmlentities($endTime->asXML());
	
	echo "Route " . $i . " start time " . $startHour . ":" . $startMinute
	. ", end time " . $endHour . ":" . $endMinute;
	echo "\n\n\n<br /><br /><hr /><br /><br />\n\n\n";
}

?>