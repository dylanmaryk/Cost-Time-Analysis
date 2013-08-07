<?php
    function costs($route) {
        global $DEBUG;
	//$processor = array(
	//'Fussweg' => function() {return 0;},
	//'Bus' => function() use ($total) {

	//	 }
	//);

	$journeycostobject = array(
				'traveltypes' => array(),
				'cost' => 0,
				'peak' => false);
        foreach ($route->interchanges as $transporttype){
	    $journeycostobject = $transporttype->price($journeycostobject);
        }
	if ($DEBUG) {echo $journeycostobject['cost'];}
        return $journeycostobject['cost'];
    }
?>
