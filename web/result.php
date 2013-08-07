<?php
  include_once 'tflxmlparser.php';
  include_once 'transportType.class.php';
  include_once 'route.class.php';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Time/Cost Analysis</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
  </head>
  <body style="padding-top: 20px;">
    <div class="container">
      <img src="img/logo.png" style="width: 50%; height: 50%; margin-left: auto; margin-right: auto; display: block;" />
      <hr>
      <table class="table">
        <thead>
          <th><b>Route</b></th>
          <th><b>Start</b></th>
          <th><b>End</b></th>
          <th><b>Duration</b></th>
          <th><b>Interchanges</b></th>
          <th></th>
        </thead>
        <tbody>
          <?php
            $i = 1;

            foreach ($routes as $routeElement) {
              ?>
              <tr>
              <td><b><?php echo $i ?></b></td>
              <td><?php echo $routeElement->departure ?></td>
              <td><?php echo $routeElement->arrival   ?></td>
              <td><?php echo $routeElement->duration  ?></td>
              <td><?php foreach ($routeElement->interchanges as $interchange) {
                echo '<img src="' . transportType::$imgDomain
                . $interchange->imgURI . '" alt="'
                . $interchange->englishName . '" />';
              } ?></td>
              <td><a href="<?php echo $routeElement->detailsLink ?>">Details</a></td>
              </tr>

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
