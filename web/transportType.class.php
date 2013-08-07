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

    	public static function createTransportType($method,$startHour,$startMinute,$start,$end) {
       	switch ($method) {
        	case 'Bus':
				return new bus($startHour,$startMinute);
			case 'Fussweg':
				return new walk;
			case 'Underground':
				return new tube($start,$end,$startHour,$startMinute);
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
	
	public $startHour;
	public $startMinute;

	public function bus($Hour,$Minute) {
		$startHour = $Hour + 0;
		$startMinute = $Minute + 0;
	}

	public function price($journeycostobject) {
		if (!array_key_exists('Bus',$journeycostobject['traveltypes'])) { $journeycostobject['traveltypes']['Bus'] = 0;}
		if (!$journeycostobject['peak']) {
			if (($startHour > 4 && $startHour < 9) 
				||($startHour == 4 && $startMinute >= 30)
				||($startHour == 9 && $startMinute <= 29)) {
				$journeycostobject['peak'] = true;
			}
		}
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
	public $startHour;
	public $startMinute;
	// does not include euston - watford junction anomoly
	private $ticketprices = array(
		'peak'=> array(
			1 => array(
				1 => 210,
				2 => 280,
				3 => 320,
				4 => 380,
				5 => 460,
				6 => 500,
				7 => 550,
				8 => 670,
				9 => 670),
			2 => array(
				2 => 160,
				3 => 160,
				4 => 230,
				5 => 270,
				6 => 270,
				7 => 390,
				8 => 450,
				9 => 450),
			3 => array(
				3 => 160,
				4 => 160,
				5 => 230,
				6 => 270,
				7 => 330,
				8 => 390,
				9 => 390),
			4 => array(
				4 => 160,
				5 => 160,
				6 => 230,
				7 => 270,
				8 => 330,
				9 => 330),
			5 => array(
				5 => 160,
				6 => 160,
				7 => 220,
				8 => 270,
				9 => 270),
			6 => array(
				6 => 270,
				7 => 390,
				8 => 450,
				9 => 450),
			7 => array(
				7 => 160,
				8 => 160,
				9 => 170),
			8 => array(
				8 => 160,
				9 => 160),
			9 => array(
				9 => 160)
		),
		'offpeak' => array(
			1 => array(
				1 => 210,
				2 => 210,
				3 => 270,
				4 => 270,
				5 => 300,
				6 => 300,
				7 => 390,
				8 => 390,
				9 => 390),
			2 => array(
				2 => 150,
				3 => 150,
				4 => 150,
				5 => 150,
				6 => 150,
				7 => 270,
				8 => 270,
				9 => 270),
			3 => array(
				3 => 150,
				4 => 150,
				5 => 150,
				6 => 150,
				7 => 160,
				8 => 160,
				9 => 160),
			4 => array(
				4 => 150,
				5 => 150,
				6 => 150,
				7 => 160,
				8 => 160,
				9 => 160),
			5 => array(
				5 => 150,
				6 => 150,
				7 => 160,
				8 => 160,
				9 => 160),
			6 => array(
				6 => 150,
				7 => 150,
				8 => 150,
				9 => 160),
			7 => array(
				7 => 150,
				8 => 150,
				9 => 150),
			8 => array(
				8 => 150,
				9 => 150),
			9 => array(
				9 => 150)
		),
	);

	public function tube($startloc,$endloc,$Hour,$Minute){
		$start = $startloc;
		$end = $endloc;
		$startHour = $Hour;
		$startMinute = $Minute;
		for($i = 1;$i <= 9; $i++ ){
			for($j = 1; $j < $i; $j++){
				$ticketprices['peak'][$i][$j] = $ticketprices['peak'][$j][$i];
				$ticketprices['offpeak'][$i][$j] = $ticketprices['offpeak'][$j][$i];
			}
		}
	}
	
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

class dlr extends transportType
{
	public $ID = 'Light Railway';
	public $englishName = 'DLR';
	public $imgURI = '/user/assets/images/icon-dlr.gif';
	public $start;
	public $end;
	
	public function price($subTotal) {
		return $journeycostobject;
		// tube specific price calcuations.
	}
}

?>
