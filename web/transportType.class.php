<?php

/**
 * Stores information about each type of transport.
 */
abstract class transportType
{
	// ID is the German name found in the productName attribute of
	// the subroute.
	public $ID = '';
	public $englishName = '';
	public $imgURI = '';
	public static $imgDomain = 'http://journeyplanner.tfl.gov.uk';
	

	public abstract function price($subTotal);

<<<<<<< Updated upstream
    public static function createTransportType($method) {
=======
    public static function createTransportType($method,$startHour,$startMinute,$startloc,$endloc) {
>>>>>>> Stashed changes
       	switch ($method) {
        	case 'Bus':
				return new bus;
			case 'Fussweg':
				return new walk;
			case 'Underground':
				return new tube($startloc,$endloc,$startHour,$startMinute);
			case 'Zug':
				return new train;
			default:
				echo('unknown transport type');
				die('unknown transport type');	  
				//return $method;       
       	}
		
	}

	public function getimgURI() { return $imgURI;}

	public function getenglishName() {return $englishName;}
	
}

class bus extends transportType
{
	public $ID = 'Bus';
	public $englishName = 'Bus';
	public $imgURI = '/user/assets/images/icon-buses.gif';
	
	public function price($subTotal) {
	    if ($subTotal <= 340) {
               return 140;
            } elseif ($subTotal <= 440) {
               return 440 - $subTotal;
            } else {
               return 0;
            }
	}
}

class walk extends transportType
{
	public $ID = 'Fussweg';
	public $englishName = 'Walk';
	public $imgURI = '/user/assets/images/icon-walk.gif';
	
	public function price($subTotal) {
		return 0;
	}
}

class tube extends transportType
{
	public $ID = 'Underground';
	public $englishName = 'Tube';
	public $imgURI = '/user/assets/images/icon-tube.gif';
	
<<<<<<< Updated upstream
	public function price($subTotal) {
=======
	public $startzone;
	public $endzone;
	
	public tube($startloc,$endloc,$Hour,$Minute){
	}

	public function price($journeycostobject) {
		return $journeycostobject;
>>>>>>> Stashed changes
		// tube specific price calcuations.
	}
}

class train extends transportType
{
	public $ID = 'Zug';
	public $englishName = 'National Rail';
	public $imgURI = '/user/assets/images/icon-rail.gif';
	public $start;
	public $end;
	
	public function price($subTotal) {
		// tube specific price calcuations.
	}
}

?>
