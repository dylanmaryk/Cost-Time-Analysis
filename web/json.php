<?php
  $originpostcode = $_GET['startAddress'];
  $destinationpostcode = $_GET['endAddress'];
  $arrdep = $_GET['arrdep'];
  $tripTime = $_GET['currentTime'];

  $means = array(
    0 => array(
      'id' => 2,
      'value' => (isset($_POST['busset'])?$_GET['busset']:true)),
    1 => array(
      'id' => 5,
      'value' => (isset($_POST['tubeset'])?$_GET['tubeset']:true)));

  include "tflxmlparser.php";

  $routesEncode = json_encode($routes);
  $routesEncode = substr_replace($routesEncode, '{ "routes": [', 0, 1);
  $routesEncode = substr_replace($routesEncode, '] }', -1, 1);

  echo $routesEncode;
?>
