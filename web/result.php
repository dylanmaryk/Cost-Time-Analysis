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
          <th><b>Interchanges</b></th>
          <th></th>
        </thead>
        <tbody>
          <?php
            $i = 1;

            foreach ($routes as $routeElement) {
<<<<<<< HEAD
              echo "<tr>";
              echo "<td><b>Route " . $i . "</b></td>";
              echo "<td>" . $routeElement['departure'] . "</td>";
              echo "<td>" . $routeElement['arrival'] . "</td>";
              echo "<td>" . $routeElement['duration'] . "</td>";
              echo "<td><a href=\"" . $routeElement['detailsLink'] . "\">View Details</a></td>";
              echo "<td>";
              foreach ($routeElement['interchanges'] as $interchange) {
                echo $interchange;
              }
              echo "</td>";
              echo "</tr>";
=======
              ?>
              <tr>
              <td><b>Route <?php echo $i ?></b></td>
              <td> <?php echo $routeElement['departure'] ?></td>
              <td> <?php echo $routeElement['arrival']   ?></td>
              <td> <?php echo $routeElement['duration']  ?></td>
              <td><a href=" <?php echo $routeElement['detailsLink'] ?> ">View Details</a></td>
              </tr>
>>>>>>> b4e9ae36dca38142a645ab264b70b43a9b2b121f

              <?php $i++;
            }
          ?>
        </tbody>
      </table>
    </div>
    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
