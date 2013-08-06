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
              echo "<td><a href=\"" . $routeElement['detailsLink'] . "\">View Details</a></td>";
              echo "</tr>";

              $i++;
            }
          ?>
        </tbody>
      </table>
    </div>
    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>