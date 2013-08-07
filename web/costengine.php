<?php
    function costs($route) {
	$total = 0;
        global $DEBUG;
	//$processor = array(
	//'Fussweg' => function() {return 0;},
	//'Bus' => function() use ($total) {
        //           if ($total <= 340) {
	//	     return 140;
        //           } elseif ($total <= 440) {
        //             return 440 - $total;
        //           } else {
        //             return 0;
        //           }
	//	 }
	//);
	
        foreach ($route['interchanges'] as $transporttype){
	    $result = $transporttype->price($total);
            $total += $result;
        }
        return $total;
    }
?>
