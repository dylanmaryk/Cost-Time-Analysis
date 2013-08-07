<?php

/**
 * Stores information about each type of transport.
 */
abstract class transportType
{
	// ID is the German name found in the productName attribute of
	// the subroute.
	public static $ID = '';
	public static $englishName = '';
	public static $imgURI = '';
	public static $imgDomain = 'http://journeyplanner.tfl.gov.uk';
	
	public abstract function price($subTotal);
	
    public static function createTransportType($method) {
       	switch ($method) {
        	case 'Bus':
				return new bus;
			case 'Fussweg':
				return new walk;
			case 'Underground':
				return new tube;
			default:
				return $method;
				//die 'unknown transport type';	         
       	}
		
	}
}

class bus extends transportType
{
	public static $ID = 'Bus';
	public static $englishName = 'Bus';
	public static $imgURI = '/user/assets/images/icon-buses.gif';
	
	public function price($subTotal) {
	    if ($total <= 340) {
               return 140;
            } elseif ($total <= 440) {
               return 440 - $total;
            } else {
               return 0;
            }
	}
}

class walk extends transportType
{
	public static $ID = 'Fussweg';
	public static $englishName = 'Walk';
	public static $imgURI = '/user/assets/images/icon-walk.gif';
	
	public function price($subTotal) {
		return 0;
	}
}

class tube extends transportType
{
	public static $ID = 'Underground';
	public static $englishName = 'Tube';
	public static $imgURI = '/user/assets/images/icon-tube.gif';
	public $start;
	public $end;
	
	public function price($subTotal) {
		// tube specific price calcuations.
	}
}

?>
