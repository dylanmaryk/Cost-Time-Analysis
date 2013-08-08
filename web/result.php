<?php  
  include_once 'transportType.class.php';
  include_once 'route.class.php';
  
  $showResults = ($_POST['request'] == 'results');
  $originpostcode = '';
  $destinationpostcode = '';
  if($showResults) {
    $arrdep = $_POST['arrdep'];
    $tripTime = $_POST['currentTime'];
    $originpostcode = $_POST['startAddress'];
    $destinationpostcode = $_POST['endAddress'];
  }
?><!DOCTYPE html>
<html lang='en'>
  <head>
    <title>Time/Cost Analysis</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen" />
    <link href="css/columnLayout.css" rel="stylesheet" media="screen" />
    <style type="text/css">
      html {
       overflow-y: scroll;
      }
    </style>
    <script type="text/javascript">
      var useDefaults1 = function() {}
      var useDefaults2 = function() {}
      window.onload = function(e) {
        start = document.getElementById('startAddress');
        end = document.getElementById('endAddress');
        useDefaults1 = function() {
          start.value = 'WD5 0DH';
          end.value = 'DA5 1AN';
        }
        useDefaults2 = function() {
          start.value = 'W12 7GF';
          end.value = 'E9 7DE';
        }
        getPostcode = function() {
          document.getElementById("startAddress").value = document.getElementById("geo").innerHTML;
        }
      }
    </script>
  </head>
  <body style='padding-top: 20px; background-color: #E0E0E0;'>
    <div class='container' style='margin: auto;'>
      <div id='wrap' style="width: 730px !important;">
        <div id='header'>
          <img src='img/logo.png' style='width: 100%; margin-left: auto; margin-right: auto; display: block;' />
          <hr/>
        </div>
        
        <?php if($showResults && !$invalidPostcode) { ?>
          <div id="tube">
            <h4>Tube</h4>
            <?php
              $means = 'tube';
              include 'resultGenerator.php';
            ?>
          </div>
          
          <div id="bus">
            <h4>Bus</h4>
            <?php
              $means = 'bus';
              include 'resultGenerator.php';
            ?>
          </div>
        <?php } ?>
        
        
        <div id="form">
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
                <select>
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
              <div class="col-offset-2 col-lg-10">
                <button type="submit" class="btn btn-primary">Calculate</button>
                <a href="javascript:getPostcode()" class="btn btn-default">Use current location</a>
              </div>
            </div>
            <div class="form-group" style="margin-top: -10px;">
              <div class="col-offset-2 col-lg-10">
                <a href="javascript:useDefaults1()" class="btn btn-default">Defaults 1</a>
                <a href="javascript:useDefaults2()" class="btn btn-default">Defaults 2</a>
              </div>
            </div>
          </form>
          <div id="geo" class="geolocation_data" style="visibility: hidden"></div>
        </div>
      </div>
    </div>
    <script src='http://code.jquery.com/jquery.js'></script>
    <script src='js/bootstrap.min.js'></script>
    <script src="js/geo.js"></script>
  </body>
</html>
