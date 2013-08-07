<?php

$DEBUG = true;

// report all errors to page
if ($DEBUG) {
	error_reporting(E_ALL);
	ini_set('display_errors', 'on');
}

include_once 'transportType.class.php';
include_once 'route.class.php';
include_once 'costengine.php';

$meansOfTransportCodes = array(
	0 => 'National Rail',
	1 => 'Docklands Light Railway',
	2 => 'London Underground',
	3 => 'London Overground',
	4 => 'Tram',
	5 => 'London Buses',
	6 => 'Bus',
	7 => 'Not Used',
	8 => 'Emirates Airline',
	9 => 'London',
	10 => 'Not Used',
	11 => 'Replacement Buses');

$transportNames = array();
$transportNames['Fussweg'] = 'Walk';
$transportNames['Bus'] = 'Bus';
$transportNames['Underground'] = 'Tube';

$transportImagesDomain = 'http://journeyplanner.tfl.gov.uk';
$transportImages = array();
$transportImages['Fussweg'] = '/user/assets/images/icon-walk.gif';
$transportImages['Bus'] = '/user/assets/images/icon-buses.gif';
$transportImages['Underground'] = '/user/assets/images/icon-tube.gif';

$originpostcode = 'AL2 1AE';
$destinationpostcode = 'SW1H 0BD';
$safeorigin = urlencode($originpostcode);
$safedestination = urlencode($destinationpostcode);

$tflurlquery = '?language=en&sessionID=0&place_origin=London&place_destination=London&type_origin=locator&name_origin=';
$tflurlquery .= $safeorigin;
$tflurlquery .= '&type_destination=locator&name_destination=';
$tflurlquery .= $safedestination;
// use if we want to allow future calculations
//$tflurlquery .= '&itdDate=' .$date. ' &itdTime=' $time;

$xmlquery = 'http://journeyplanner.tfl.gov.uk/user/XML_TRIP_REQUEST2' . $tflurlquery;

$curl = curl_init();
curl_setopt_array($curl, array(
	CURLOPT_RETURNTRANSFER => 1,
	CURLOPT_URL => $xmlquery,
	CURLOPT_USERAGENT => 'INSERT_DESCRIPTION_OF_SERVICE, INSERT_EMAIL_ADDRESS'
));

$xmlstring = curl_exec($curl);
//probably should check this
$responsecode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
//echo $xmlstring;
$xml = simplexml_load_string($xmlstring);
//var_dump($xml);
$xmlroutes = $xml->itdTripRequest->itdItinerary->itdRouteList;
//var_dump($routes);
//echo $routes->asXML();

// iterate through all the routes and print out the start and end times.
$i = 0;
$routes = array();
foreach ($xmlroutes->itdRoute as $route) {
	
	$prl = $route->itdPartialRouteList;
	
	$startTime = $prl->itdPartialRoute->itdPoint->itdDateTime->itdTime;
	$startHour = $startTime['hour'];
	$startMinute = $startTime['minute'];
	
	$endpr = $prl->itdPartialRoute[count($prl->itdPartialRoute) - 1];
	$endTime = $endpr->itdPoint[count($endpr->itdPoint) - 1]->itdDateTime->itdTime;
	$endHour = $endTime['hour'];
	$endMinute = $endTime['minute'];
	
	$travelTime = $route['publicDuration'];
	
	$interchanges = array();
	$j = 0;
	foreach ($prl->itdPartialRoute as $partialRoute) {
		$method = $partialRoute->itdMeansOfTransport['productName'];
		if ($method . "" != "") {
			$interchanges[$j] = transportType::createTransportType($method . "");
			$j++;
		}
	}
	
	$detailsLink = 'http://journeyplanner.tfl.gov.uk/user/XSLT_TRIP_REQUEST2'
	. $tflurlquery . "&tripSelector" . ($i + 1) . "=1&itdLPxx_view=detail";
	
	/*
	$routes[$i] = array();
	$routes[$i]['departure'] = date ('H:i', strtotime($startHour . ":" . $startMinute));
	$routes[$i]['arrival'] = date ('H:i', strtotime($endHour . ":" . $endMinute));
	$routes[$i]['duration'] = date ('H:i', strtotime($travelTime));
	$routes[$i]['detailsLink'] = $detailsLink;
	$routes[$i]['interchanges'] = $interchanges;
	$routes[$i]['cost'] = costs($routes[$i]);
	 */
	$departure = date ('H:i', strtotime($startHour . ":" . $startMinute));
	$arrival = date ('H:i', strtotime($endHour . ":" . $endMinute));
	$duration  = date ('H:i', strtotime($travelTime));

	 
	$routes[$i] = new route($departure, $arrival, $duration, $detailsLink, $interchanges);
	$routes[$i]->cost = costs($routes[$i]); 
    $i++;
}

if ($DEBUG) var_dump($routes);

?>
