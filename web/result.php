<?php
  include "tflxmlparser.php";
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
          <th><b>End Time</b></th>
          <th><b>Travel Time</b></th>
          <th></th>
        </thead>
        <tbody>
          <?php
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

              $travelTime = $route['publicDuration'];

              $startTimeFormatted = $startHour . ":" . $startMinute;
              $endTimeFormatted = $endHour . ":" . $endMinute;

              echo "<tr>";
              echo "<td><b>Route " . $i . "</b></td>";
              echo "<td>" . date ('H:i', strtotime($startTimeFormatted)) . "</td>";
              echo "<td>" . date ('H:i', strtotime($endTimeFormatted)) . "</td>";
              echo "<td>" . date ('H:i', strtotime($travelTime)) . "</td>";
              echo "<td><a href=" .  . ">View Details</a></td>";
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