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
	

	public abstract function price($journeycostobject);

    public static function createTransportType($method) {
       	switch ($method) {
        	case 'Bus':
				return new bus;
			case 'Fussweg':
				return new walk;
			case 'Underground':
				return new tube;
			case 'Zug':
				return new train;
			default:
				echo('unknown transport type: '. $method);
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
	
	public function price($journeycostobject) {
		if (!array_key_exists('Bus',$journeycostobject['traveltypes'])) { $journeycostobject['traveltypes']['Bus'] = 0;}
		if (count($journeycostobject['traveltypes']) == 1 && array_key_exists('Bus',$journeycostobject['traveltypes'])) {
	    	if ($journeycostobject['cost'] <= 340) {
				$journeycostobject['cost'] += 140;   
            } elseif ($journeycostobject['cost'] <= 440) {
               $journeycostobject['cost'] += (440 - $journeycostobject['cost']);
            } else {
        	}
		} else {
			die ("bus does not know how to handle non bus transport forms");
		}
		return $journeycostobject;
	}
}

class walk extends transportType
{
	public $ID = 'Fussweg';
	public $englishName = 'Walk';
	public $imgURI = '/user/assets/images/icon-walk.gif';
	
	public function price($journeycostobject) {
		return $journeycostobject;
	}
}

class tube extends transportType
{
	public $ID = 'Underground';
	public $englishName = 'Tube';
	public $imgURI = '/user/assets/images/icon-tube.gif';
	public $start;
	public $end;
	
	public function price($journeycostobject) {
		return $journeycostobject;
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
	
	public function price($journeycostobject) {
		return $journeycostobject;
		// tube specific price calcuations.
	}
}

?>
