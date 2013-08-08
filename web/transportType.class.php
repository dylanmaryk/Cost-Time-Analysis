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
			case 'Light Railway':
				return new dlr;
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
		if ($Hour == "")  {die( "missing hour");}
		$this->startHour = $Hour + 0;
		$this->startMinute = $Minute + 0;
	}

	public function price($journeycostobject) {
		$journeycostobject['inzonejourney'] = false;
		if ($journeycostobject['cap'] < 440) $journeycostobject['cap'] = 440;
		if (!array_key_exists('Bus',$journeycostobject['traveltypes'])) { $journeycostobject['traveltypes']['Bus'] = 0;}
		if (!$journeycostobject['peak']) {
			if (($this->startHour > 4 && $this->startHour < 9) 
				||($this->startHour == 4 && $this->startMinute >= 30)
				||($this->startHour == 9 && $this->startMinute <= 29)) {
				$journeycostobject['peak'] = true;
			}
		}
    	if ($journeycostobject['cost'] <= ($journeycostobject['cap'] - 140)) {
			$journeycostobject['cost'] += 140;   
        } elseif ($journeycostobject['cost'] <= $journeycostobject['cap']) {
           $journeycostobject['cost'] += ($journeycostobject['cap'] - $journeycostobject['cost']);
        } else {
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
		$journeycostobject['inzonejourney'] = false;
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
	public static $ticketprices = array(
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
		'peakcaps'=> array(
			1 => array(
				1 => 840,
				2 => 840,
				3 => 1060,
				4 => 1060,
				5 => 1580,
				6 => 1580,
				7 => 1960,
				8 => 1960,
				9 => 1960),
			2 => array(
				2 => 840,
				3 => 1060,
				4 => 1060,
				5 => 1580,
				6 => 1580,
				7 => 1960,
				8 => 1960,
				9 => 1960),
			3 => array(
				3 => 1060,
				4 => 1060,
				5 => 1580,
				6 => 1580,
				7 => 1960,
				8 => 1960,
				9 => 1960),
			4 => array(
				4 => 1060,
				5 => 1580,
				6 => 1580,
				7 => 1960,
				8 => 1960,
				9 => 1960),
			5 => array(
				5 => 1580,
				6 => 1580,
				7 => 1960,
				8 => 1960,
				9 => 1960),
			6 => array(
				6 => 1580,
				7 => 1960,
				8 => 1960,
				9 => 1960),
			7 => array(
				7 => 1960,
				8 => 1960,
				9 => 1960),
			8 => array(
				8 => 1960,
				9 => 1960),
			9 => array(
				9 => 1960)
		),
		'offpeakcaps' => array(
			1 => array(
				1 => 700,
				2 => 700,
				3 => 770,
				4 => 770,
				5 => 850,
				6 => 850,
				7 => 1160,
				8 => 1160,
				9 => 1160),
			2 => array(
				2 => 700,
				3 => 770,
				4 => 770,
				5 => 850,
				6 => 850,
				7 => 1160,
				8 => 1160,
				9 => 1160),
			3 => array(
				3 => 770,
				4 => 770,
				5 => 850,
				6 => 850,
				7 => 1160,
				8 => 1160,
				9 => 1160),
			4 => array(
				4 => 770,
				5 => 850,
				6 => 850,
				7 => 1160,
				8 => 1160,
				9 => 1570),
			5 => array(
				5 => 850,
				6 => 850,
				7 => 1160,
				8 => 1160,
				9 => 1160),
			6 => array(
				6 => 850,
				7 => 1160,
				8 => 1160,
				9 => 1160),
			7 => array(
				7 => 1160,
				8 => 1160,
				9 => 1160),
			8 => array(
				8 => 1160,
				9 => 1160),
			9 => array(
				9 => 1160)
		),
	);

	public function tube($startloc,$endloc,$Hour,$Minute){
		global $DEBUG;
		if ($DEBUG) {
			echo "start zone: $startloc \n";
			echo "end zone $endloc \n";
		}
		$this->start = $startloc;
		$this->end = $endloc;
		$this->startHour = $Hour;
		$this->startMinute = $Minute;
		if (!array_key_exists(1,self::$ticketprices['peak'][2])) {
			for($i = 1;$i <= 9; $i++ ){
				for($j = 1; $j < $i; $j++){
					self::$ticketprices['peak'][$i][$j] = self::$ticketprices['peak'][$j][$i];
					self::$ticketprices['offpeak'][$i][$j] = 
						self::$ticketprices['offpeak'][$j][$i];
					self::$ticketprices['offpeakcaps'][$i][$j] = 
						self::$ticketprices['offpeakcaps'][$j][$i];
					self::$ticketprices['peakcaps'][$i][$j] = 
						self::$ticketprices['peakcaps'][$j][$i];
				}
			}
		}
	}
	
	public function price($journeycostobject) {
		
		if (!$journeycostobject['inzonejourney']) {
			$journeycostobject['start zone'] = $this->start;
			$journeycostobject['inzonejourney'] = true;
		} else {
			$ispeak = $journeycostobject['peak'];
			$journeycostobject['cost'] = $journeycostobject['cost'] - 
				self::$ticketprices[($ispeak?'peak' :'offpeak')][$journeycostobject['start zone']]
					[$journeycostobject['finish zone']];
		}
		$ispeak = ($journeycostobject['peak']
				||($this->startHour > 6 && $this->startHour < 9) 
				||($this->startHour == 6 && $this->startMinute >= 30)
				||($this->startHour == 9 && $this->startMinute <= 29));
		$journeycostobject['finish zone'] = $this->end;
		global $DEBUG;
		if ($DEBUG) {
			echo "start zone: " . $journeycostobject['start zone'];
			echo "end zone: " . $journeycostobject['finish zone'];
		}
		$journeycostobject['cost'] = $journeycostobject['cost'] + 
			self::$ticketprices[($ispeak ?'peak' :'offpeak')][$journeycostobject['start zone']]
					[$journeycostobject['finish zone']];
		$journeycostobject['peak'] = $ispeak;
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
