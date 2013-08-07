<?php
    function costs($route) {
	$total = 0;
        global $DEBUG;
	//$processor = array(
	//'Fussweg' => function() {return 0;},
	//'Bus' => function() use ($total) {

	//	 }
	//);
	
        foreach ($route->interchanges as $transportType) {
	    	$result = $transportType->price($total);
            $total += $result;
        }
        return $total;
    }
?>
