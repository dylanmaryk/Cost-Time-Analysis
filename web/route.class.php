<?php

class route
{
	public $departure; // date
	public $arrival; // date
	public $duration; // date
	public $detailsLink; // string
	public $interchanges; // transportType[]. That is to say an array of
	                      // transportType objects.
	private $restrictions;
	public $cost;
	
	public function route($de, $ar, $du, $li, $in, $restrictions) {
		$this->departure = $de;
		$this->arrival = $ar;
		$this->duration = $du;
		$this->detailsLink = $li;
		$this->interchanges = $in;
		$this->restrictions = $restrictions;
	}
	
	public function equals($route) {
		return (/*($this->interchanges == $route->interchanges) && */
			($this->restrictions == $route->restrictions) &&
			($this->departure == $route->departure));
	}

}

?>
