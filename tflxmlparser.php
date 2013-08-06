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
	//$starthour = $route->itdPartialRouteList->itdPartialRoute[0]->itdPoint[0]->itdDateTime->itdTime['hour'];
	//echo $starthour;
	
	//$partialroute = $route->itdPartialRouteList->itdPartialRoute;
	//$partialroute = $route->xpath('itdPartialRouteList/itdPartialRoute[1]');
	$time = $route->itdPartialRouteList->itdPartialRoute->itdPoint->itdDateTime->itdTime;
	$hour = $time['hour'];
	$minute = $time['minute'];
	//var_dump($time);
	//echo "\n\n\n<br /><br /><hr /><br /><br />\n\n\n";
	echo "Route " . $i . " start time " . $hour . ":" . $minute;
	echo "\n\n\n<br /><br /><hr /><br /><br />\n\n\n";
	
	/*
	var_dump($route);
	echo "\n\n\n<br /><br /><hr /><br /><br />\n\n\n";
	echo htmlentities($route->asXML());
	echo "\n\n\n<br /><br /><hr /><br /><br />\n\n\n";
	 */
}

?>