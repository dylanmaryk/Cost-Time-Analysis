<?php
    function costs($route) {
	$total = 0;
        global $DEBUG;
	//$processor = array(
	//'Fussweg' => function() {return 0;},
	//'Bus' => function() use ($total) {

	//	 }
	//);
	
        foreach ($route->interchanges as $transporttype){
	    $result = $transporttype->price($total);
            $total += $result;
        }
	if ($DEBUG) {echo $total;}
        return $total;
    }
?>
