<?php
$DEBUG = false;
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

$safeorigin = urlencode($originpostcode);
$safedestination = urlencode($destinationpostcode);

$tflurlquery = '?language=en&sessionID=0&place_origin=London&place_destination=London&type_origin=locator&name_origin=';
$tflurlquery .= $safeorigin;
$tflurlquery .= '&type_destination=locator&name_destination=';
$tflurlquery .= $safedestination;
$tflurlquery .= '&itdTripDateTimeDepArr=';
//$deparr = 'dep';
$tflurlquery .= $deparr;
foreach ($means as $transitem) {
	if ($transitem['value']) $tflurlquery .= '&includedMeans=' . $transitem['id'];
}

$xmlquery = 'http://journeyplanner.tfl.gov.uk/user/XML_TRIP_REQUEST2' . $tflurlquery . '&itdTime=' . $tripTime;

$curl = curl_init();
curl_setopt_array($curl, array(
	CURLOPT_RETURNTRANSFER => 1,
	CURLOPT_URL => $xmlquery,
	CURLOPT_USERAGENT => 'INSERT_DESCRIPTION_OF_SERVICE, INSERT_EMAIL_ADDRESS'
));

$xmlstring = curl_exec($curl);
//probably should check this
$responsecode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

if ($responsecode != 200) {
	die ("bad response");
}

//echo $xmlstring;
$xml = simplexml_load_string($xmlstring);
//var_dump($xml);
$invalidPostcode = false;
foreach($xml->itdTripRequest->itdOdv as $location) {
	if ($location->itdOdvName['state'] == 'list' || ($location->itdOdvName['state'] == 'empty' && $location['usage'] != 'via')){
		$invalidPostcode = true;
	}
}
$routes = isset($routes)?$routes:array();
if (!$invalidPostcode && ((string)$xml->itdTripRequest->itdMessage == "")) {
	$xmlroutes = $xml->itdTripRequest->itdItinerary->itdRouteList;
	//var_dump($routes);
	//echo $routes->asXML();

	// iterate through all the routes and print out the start and end times.
	$i = count($routes);
	foreach ($xmlroutes->itdRoute as $route) {
		$routesToZones = array();
		if ($route->itdFare->count() != 0) {
			foreach ($route->itdFare->itdTariffzones as $routezones) {
				$j = 0;
				foreach ($routezones->itdZones as $zone){
					$zonenum[$j] = ($zone->zoneElem . "") + 0;
					$j++;
				}
				if (count($zonenum) == 1) {$zonenum[1] = $zonenum[0];}
				$zonePR = $routezones->attributes()->toPR + 0;
				$routesToZones[$zonePR] = $zonenum;
			}
		}
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
			if ($method == 'Wheelchair Access') continue;
		
			if ($method . '' == '') {
				$method = 'Zug';
			}
			//if ($DEBUG){echo $method . ', ';}
			foreach ($partialRoute->itdPoint as $point) {
				if ($point->attributes()->usage == 'arrival') {
					$time = $point->itdDateTime->itdTime;
					$arrivalStartHour = $time['hour'];
					$arrivalStartMinute = $time['minute'];
				} elseif ($point->attributes()->usage == 'departure') {
				} else {
					die('unknown point type');
				}
			}
			$arrivalLoc = 0;
			$destination = 0;
			if (array_key_exists($j,$routesToZones)) {
				$arrivalLoc = $routesToZones[$j][0];
				$destination = $routesToZones[$j][1];
			}
			$interchanges[$j] = transportType::createTransportType($method . '',$arrivalStartHour,$arrivalStartMinute,$arrivalLoc,$destination);
			$j++;
		}
	
		$departure = date ('H:i', strtotime($startHour . ':' . $startMinute));
		$arrival = date ('H:i', strtotime($endHour . ':' . $endMinute));
		$duration  = date ('H:i', strtotime($travelTime));
	
		$detailsLink = 'http://journeyplanner.tfl.gov.uk/user/XSLT_TRIP_REQUEST2'
		. $tflurlquery . '&itdLPxx_view=detail&calcNumberOfTrips=1&noAlt=1&itdTime='
		. $departure . '&itdTripDateTimeDepArr=dep';
		$thisroute = new route($departure, $arrival, $duration, $detailsLink, $interchanges,$means);
		$found = false;
		foreach ($routes as $currentroute) {
			if($thisroute->equals($currentroute)){				
				$found = true;
				break;
			}
		}
		if(!$found) {
			$routes[$i] = $thisroute;
			$routes[$i]->cost = costs($routes[$i]); 
   			$i++;
		}
	}

	//if ($DEBUG) var_dump($routes);
	if ($DEBUG) echo $xmlquery;
}
?>
