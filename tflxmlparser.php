<?php

// Make a web request for a short link to the Wikipedia article
$curl = curl_init();
$tflurlquery = 'http://journeyplanner.tfl.gov.uk/user/XML_TRIP_REQUEST2?language=en&place_origin=London&type_origin=locator&name_origin=';
$tflurlquery .= $originpostcode;
$tflurlquery .= '&place_destination=London&type_destination=locator&name_destination=';
$tflurlquery .= $destinationpostcode;
// use if we want to allow future calculations
//$tflurlquery .= '&itdDate=' .$date. ' &itdTime=' $time;

curl_setopt_array($curl, array(
CURLOPT_RETURNTRANSFER => 1,
CURLOPT_URL => $tflurlquery,
CURLOPT_USERAGENT => 'INSERT_DESCRIPTION_OF_SERVICE, INSERT_EMAIL_ADDRESS'
));

$xmlstring = curl_exec($curl);
//probably should check this
$responsecode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
echo $xmlstring;
$xml = simplexml_load_string($xmlstring);


?>