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
            $i = 1;

            foreach ($routes as $routeElement) {
              echo "<tr>";
              echo "<td><b>Route " . $i . "</b></td>";
              echo "<td>" . $routeElement['departure'] . "</td>";
              echo "<td>" . $routeElement['arrival'] . "</td>";
              echo "<td>" . $routeElement['duration'] . "</td>";
              echo "<td>" . $routeElement['detailsLink'] . "</td>";
              echo "</tr>";

              $i++;
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