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
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Time/Cost Analysis</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
  </head>
  <body>
    <div class="container">
      <h1 align="center">Time/Cost Analysis</h1>
      <hr>
      <table class="table">
        <thead>
          <th></th>
          <th><b>Start Time</b></th>
        </thead>
        <tbody>
          <?php
            foreach ($routes->itdRoute as $route) {
              $i++;
              
              $time = $route->itdPartialRouteList->itdPartialRoute->itdPoint->itdDateTime->itdTime;
              $hour = $time['hour'];
              $minute = $time['minute'];

              echo "<tr>";
              echo "<td><b>Route " . $i . "</b></td>";
              echo "<td>" . $hour . " hr " . $minute . " min" . "</td>";
              echo "</tr>";
            }
          ?>
        </tbody>
      </table>
      <!-- <table class="table">
        <thead>
          <th></th>
          <th><b>Time</b></th>
          <th><b>Cost</b></th>
        </thead>
        <tbody>
          <tr>
            <td><b>Bus</b></td>
            <td>1 hr 15 mins</td>
            <td>&pound;2.20</td>
          </tr>
          <tr>
            <td><b>Tube</b></td>
            <td>45 mins</td>
            <td>&pound;4.30</td>
          </tr>
        </tbody>
      </table> -->
    </div>
    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>