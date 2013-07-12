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
		$this->beforeFilter('csrf', array('on'=>array('post', 'put', 'patch', 'delete')));
		$state_list = array('Alabama'=>"AL", 'Alaska'=>"AK", 'Arizona'=>"AZ", 
													'Arkansas'=>"AR", 'California'=>"CA", 'Colorado'=>"CO", 
													'Connecticut'=>"CT", 'Delaware'=>"DE", 'District Of Columbia'=>"DC", 
													'Florida'=>"FL", 'Georgia'=>"GA", 'Hawaii'=>"HI", 'Idaho'=>"ID", 
													'Illinois'=>"IL", 'Indiana'=>"IN", 'Iowa'=>"IA", 'Kansas'=>"KS", 
													'Kentucky'=>"KY", 'Louisiana'=>"LA", 'Maine'=>"ME", 
													'Maryland'=>"MD", 'Massachusetts'=>"MA", 'Michigan'=>"MI", 
													'Minnesota'=>"MN", 'Mississippi'=>"MS", 'Missouri'=>"MO", 
													'Montana'=>"MT", 'Nebraska'=>"NE", 'Nevada'=>"NV", 
													'New Hampshire'=>"NH", 'New Jersey'=>"NJ", 'New Mexico'=>"NM", 
													'New York'=>"NY", 'North Carolina'=>"NC", 'North Dakota'=>"ND", 
													'Ohio'=>"OH", 'Oklahoma'=>"OK", 'Oregon'=>"OR", 
													'Pennsylvania'=>"PA", 'Rhode Island'=>"RI", 'South Carolina'=>"SC", 
													'South Dakota'=>"SD", 'Tennessee'=>"TN", 'Texas'=>"TX", 'Utah'=>"UT", 
													'Vermont'=>"VT", 'Virginia'=>"VA", 'Washington'=>"WA", 
													'West Virginia'=>"WV", 'Wisconsin'=>"WI", 'Wyoming'=>"WY");
		View::share('state_list', $state_list);
	}


}