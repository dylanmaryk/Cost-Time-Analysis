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
	
	public abstract function price($subTotal, $start, $end) {
		// work out the price of this subRoute
	}
}

class bus extends transportType
{
	public static $ID = 'Bus';
	public static $englishName = 'Bus';
	public static $imgURI = '/user/assets/images/icon-buses.gif';
	
	public function price($subTotal, $start, $end) {
		// bus specific price calculations
	}
}

class walk extends transportType
{
	public static $ID = 'Fussweg';
	public static $englishName = 'Walk';
	public static $imgURI = '/user/assets/images/icon-walk.gif';
	
	public function price($subTotal, $start, $end) {
		return 0;
	}
}

class tube extends transportType
{
	public static $ID = 'Underground';
	public static $englishName = 'Tube';
	public static $imgURI = '/user/assets/images/icon-tube.gif';
	
	public function price($subTotal, $start, $end) {
		// tube specific price calcuations.
	}
}

?>