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
            foreach ($routes as $route) {
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