<?php
  $originpostcode = $_GET['startAddress'];
  $destinationpostcode = $_GET['endAddress'];

  include "tflxmlparser.php";

  $routesEncode = json_encode($routes);
  $routesEncode = substr_replace($routesEncode, '{ "routes": [', 0, 1);
  $routesEncode = substr_replace($routesEncode, '] }', -1, 1);

  echo $routesEncode;
?>
