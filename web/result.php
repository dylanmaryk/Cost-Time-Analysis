<?php  
  include_once 'transportType.class.php';
  include_once 'route.class.php';
  
  $showResults = ($_POST['request'] == 'results');
  $originpostcode = '';
  $destinationpostcode = '';
  if($showResults) {
	error_reporting(E_ALL);
	ini_set('display_errors', 'on');
    $deparr = $_POST['arrdep'];
    $tripTime = $_POST['currentTime'];
    $originpostcode = $_POST['startAddress'];
    $destinationpostcode = $_POST['endAddress'];
    if((!array_key_exists('busset',$_POST) && !array_key_exists('tubeset',$_POST)) || (array_key_exists('busset',$_POST) && array_key_exists('tubeset',$_POST) && $_POST['busset'] == "on" && $_POST['tubeset'] == "on")){
      $means = array(
	0 => array(
		'id' => 5,
		'value' => true),
	1 => array(
		'id' => 2,
		'value' => true));
      include 'tflxmlparser.php';
      $means = array(
	0 => array(
		'id' => 5,
		'value' => (false)),
	1 => array(
		'id' => 2,
		'value' => (true)));
      include 'tflxmlparser.php';
            $means = array(
	0 => array(
		'id' => 5,
		'value' => (true)),
	1 => array(
		'id' => 2,
		'value' => (false)));
      include 'tflxmlparser.php';
    } else {
    $means = array(
	0 => array(
		'id' => 5,
		'value' => (array_key_exists('busset',$_POST) && $_POST['busset'] == "on" ?true:false)),
	1 => array(
		'id' => 2,
		'value' => (array_key_exists('tubeset',$_POST) && $_POST['tubeset'] == "on" ?true:false)));
    include_once 'tflxmlparser.php';
    }
  }
?><!DOCTYPE html>
<html lang='en'>
  <head>
    <title>Time/Cost Analysis</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <style type="text/css">
      html {
       overflow-y: scroll;
      }
    </style>
    <script type="text/javascript">
      var useDefaults = function() {}
      window.onload = function(e) {
        useDefaults = function() {
          start = document.getElementById('startAddress');
          end = document.getElementById('endAddress');
          start.value = 'SW1H 0BD';
          end.value = 'SE11 5TN';
        }
        getPostcode = function() {
          document.getElementById("startAddress").value = document.getElementById("geo").innerHTML;
        }
      }
    </script>
  </head>
  <body style='padding-top: 20px; background-color: #E0E0E0;'>
    <div class='container' style='width: 360px; margin: auto;'>
      <img src='img/logo.png' style='width: 100%; height: 100%; margin-left: auto; margin-right: auto; display: block;' />
      <hr/>
      <?php if($showResults && !$invalidPostcode) { ?>
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
        <hr style='width: 360px; margin: auto; margin-bottom: 25px' />
      <?php } ?>
      <?php if($invalidPostcode) { ?>
        <h3> Invalid Postcode </h3>
      <?php } ?>
      <form style='width: 360px; margin: auto;' class="form-horizontal" action="result.php" method="post">
        <input type="hidden" name="request" value="results" />
        <div class="form-group">
          <label for="startAddress" class="col-lg-4 control-label" id="formLabel">Start address</label>
          <div class="col-lg-8">
            <input type="text" class="col-lg-9 form-control" id="startAddress" name="startAddress" value="<?php echo $originpostcode ?>">
          </div>
        </div>
        <div class="form-group">
          <label for="endAddress" class="col-lg-4 control-label" id="formLabel">End address</label>
          <div class="col-lg-8">
            <input type="text" class="form-control" id="endAddress" name="endAddress" value="<?php echo $destinationpostcode ?>">
          </div>
        </div>
        <div class="form-group">
          <label for="currentTime" class="col-lg-4 control-label" id="formLabel">Start/end time</label>
          <div class="col-lg-3" style="margin-top: 6px;">
            <select name="arrdep">
              <option value="dep">Leaving</option>
              <option value="arr">Arriving</option>
            </select>
          </div>
          <div class="col-lg-5">
            <input type="text" class="form-control" id="currentTime" name="currentTime"
            value="<?php if(!isset($tripTime)){ date_default_timezone_set('Europe/London'); echo date('H:i'); } else { echo $tripTime; }?>">
          </div>
        </div>
        <div class="form-group">
          <label class="col-lg-4 control-label" id="formLabel">Bus/Tube only</label>
          <div style="margin-top: 9px;">
            <div class="col-lg-1">
              <input name="busset" type="checkbox" checked />
            </div>
            <div class="col-lg-3">
              Bus
            </div>
            <div class="col-lg-1">
              <input name="tubeset" type="checkbox" checked />
            </div>
            <div class="col-lg-3">
              Tube
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="col-offset-2 col-lg-10">
            <button type="submit" class="btn btn-primary">Calculate</button>
            <a href="javascript:getPostcode()" class="btn btn-default">Use current location</a>
          </div>
        </div>
        <div class="form-group" style="margin-top: -10px;">
          <div class="col-offset-2 col-lg-10">
            <a href="javascript:useDefaults()" class="btn btn-default">Use defaults</a>
          </div>
        </div>
      </form>
      <div id="geo" class="geolocation_data" style="visibility: hidden"></div>
    </div>
    <script src='http://code.jquery.com/jquery.js'></script>
    <script src='js/bootstrap.min.js'></script>
    <script src="js/geo.js"></script>
  </body>
</html>
