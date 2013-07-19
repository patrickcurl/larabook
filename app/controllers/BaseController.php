<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

	public function __construct(){
		$this->beforeFilter("csrf", array("on"=>array("post", "put", "patch", "delete")));
    $state_list = array(
          "" => "", // Base or Default case.
          "AL"=>"Alabama", "AK"=>"Alaska", 
          "AZ"=>"Arizona", "AR"=>"Arkansas", 
          "CA"=>"California", "CO"=>"Colorado", 
          "CT"=>"Connecticut", "DE"=>"Delaware", 
          "DC"=>"District Of Columbia", "FL"=>"Florida", 
          "GA"=>"Georgia", "HI"=>"Hawaii", 
          "ID"=>"Idaho", "IL"=>"Illinois", 
          "IN"=>"Indiana", "IA"=>"Iowa", 
          "KS"=>"Kansas", "KY"=>"Kentucky", 
          "LA"=>"Louisiana", "ME"=>"Maine", 
          "MD"=>"Maryland", "MA"=>"Massachusetts", 
          "MI"=>"Michigan", "MN"=>"Minnesota", 
          "MS"=>"Mississippi", "MO"=>"Missouri", 
          "MT"=>"Montana", "NE"=>"Nebraska", 
          "NV"=>"Nevada", "NH"=>"New Hampshire", 
          "NJ"=>"New Jersey", "NM"=>"New Mexico", 
          "NY"=>"New York",  "NC"=>"North Carolina", 
          "ND"=>"North Dakota", "OH"=>"Ohio", 
          "OK"=>"Oklahoma",  "OR"=>"Oregon", 
          "PA"=>"Pennsylvania", "RI"=>"Rhode Island", 
          "SC"=>"South Carolina", "SD"=>"South Dakota", 
          "TN"=>"Tennessee", "TX"=>"Texas", 
          "UT"=>"Utah", "VT"=>"Vermont", 
          "VA"=>"Virginia", "WA"=>"Washington", 
          "WV"=>"West Virginia", "WI"=>"Wisconsin", 
          "WY"=>"Wyoming");
		View::share("state_list", $state_list);
	}


}