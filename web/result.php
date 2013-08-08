<?php

  include_once 'transportType.class.php';
  include_once 'route.class.php';
  
  $showResults = ($_POST['request'] == 'results');
  $originpostcode = '';
  $destinationpostcode = '';
  if($showResults) {
    $originpostcode = $_POST['startAddress'];
    $destinationpostcode = $_POST['endAddress'];
  }
  include_once 'tflxmlparser.php';
?>
<!DOCTYPE html>
<html lang='en'>
  <head>
    <title>Time/Cost Analysis</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <script type="text/javascript">
      var useDefaults = function() {}
      window.onload = function(e) {
        useDefaults = function() {
          start = document.getElementById('startAddress');
          end = document.getElementById('endAddress');
          start.value = 'SW1H 0BD';
          end.value = 'SE11 5TN';
        }
      }
    </script>
  </head>
  <body style='padding-top: 20px;'>
    <div class='container'>
      <img src='img/logo.png' style='width: 50%; height: 50%; margin-left: auto; margin-right: auto; display: block;' />
      <hr/>
      <?php if(!$invalidPostcode) { ?>
        <?php if($showResults) { ?>
          <table class='table' style='width: 360px; margin: auto;'>
            <thead>
              <th></th>
              <th><b>Start</b></th>
              <th><b>End</b></th>
              <th><b>Duration</b></th>
              <th><b>Cost</b></th>
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
                  <td>&pound;<?php printf("%01.2f", $routeElement->cost/100)?></td>
                  <td><a href="<?php echo $routeElement->detailsLink ?>">Details</a></td>
                </tr>
                <tr>
                  <td colspan="6" style="border-top: none;">
                    <b>Interchanges:</b>
                    <div style="float: right;">
                      <?php foreach ($routeElement->interchanges as $interchange) {
                        echo '<img src="' . transportType::$imgDomain
                        . $interchange->imgURI . '" alt="'
                        . $interchange->englishName . '" />';
                      } ?>
                    </div>
                  </td>
                </tr>
                <?php $i++;
              }
            ?>
          </tbody>
        </table>
      <?php } else { ?>
      <h3> Invalid Postcode </h3>
      <?php }
   } ?>
      <form class="form-horizontal" action="result.php" method="post">
        <input type="hidden" name="request" value="results" />
        <div class="form-group">
          <label for="startAddress" class="col-lg-2 control-label" id="formLabel">Start address</label>
          <div class="col-lg-10">
            <input type="text" class="col-lg-9 form-control" id="startAddress" name="startAddress" value="<?php echo $originpostcode ?>">
          </div>
        </div>
        <div class="form-group">
          <label for="endAddress" class="col-lg-2 control-label" id="formLabel">End address</label>
          <div class="col-lg-10">
            <input type="text" class="form-control" id="endAddress" name="endAddress" value="<?php echo $destinationpostcode ?>">
          </div>
        </div>
        <div class="form-group">
          <div class="col-offset-2 col-lg-10">
            <button type="submit" class="btn btn-primary">Calculate</button>
            <a href="javascript:getPostcode()" class="btn btn-default">Use current location</a>
            <a href="javascript:useDefaults()" class="btn btn-default">Use Defaults</a>
          </div>
        </div>
      </form>
    </div>
    <script src='http://code.jquery.com/jquery.js'></script>
    <script src='js/bootstrap.min.js'></script>
  </body>
</html>
