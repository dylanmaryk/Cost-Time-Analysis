<?php

class route
{
	public $departure; // date
	public $arrival; // date
	public $duration; // date
	public $detailsLink; // string
	public $interchanges; // transportType[]. That is to say an array of
	                      // transportType objects.
	public $cost;
	
	public function route($de, $ar, $du, $li, $in, $co) {
		$this->departure = $de;
		$this->arrival = $ar;
		$this->duration = $du;
		$this->detailsLink = $li;
		$this->interchanges = $in;
		$this->cost = $co;
	}
}

?>