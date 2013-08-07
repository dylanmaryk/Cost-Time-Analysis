<?php
  $originpostcode = $_GET['startAddress'];
  $destinationpostcode = $_GET['endAddress'];
  include "tflxmlparser.php";
  echo json_encode($routes);
?>
