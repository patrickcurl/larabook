<?php

class BookController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/
	protected $layout = 'layouts.master';

	public function getLookup()
	{
		
		if(Input::has('isbn')){
			$isbn = Input::get('isbn');
			$book = Book::find_or_create($isbn);
			$books = Book::take(4)->orderBy('updated_at')->get();
			$dir = Input::get('dir');
			$orderby = Input::get('orderby');
			if (!$dir){ $dir = 'ASC';}
			if (!$orderby){$orderby = "merchant_id";}
    	$prices = Book::getPrices($book, $orderby, $dir);
    	$url = "http://www.recycleabook.com/search_isbn.php?isbn=$isbn";
    	//$response = simplexml_load_file($url);
    	//$response = Book::cache_xml($isbn, 'recycleabook', $url);
    	//var_dump($response);
    	//$buyback = $response->details->buyback;

    	//if ($buyback == 'Not buying this book'){
    	//	$buyback =number_format(floatval(0), 2);
    	//} else { 
    	//		$buyback = (int) $buyback;
    	//		$buyback = number_format(floatval($buyback), 2); }
    	$xml_recycleabook = Book::cache_xml($isbn, 'recycleabook', "http://www.recycleabook.com/search_isbn.php?isbn=$isbn");
    	if(Cache::has("rab{$isbn}")){
    		$rab = Cache::get("rab{$isbn}");
    		$rab = new SimpleXMLElement($rab);

    	} else {
    		$rab = @simplexml_load_file($url);
    		if($rab){
    			$rab_x = $rab->asXML();
    			Cache::add("rab{$isbn}", $rab_x, 400);
    		} else {
    			$rab = NULL;
    		}
    	}
    	if ($rab) {
	    	$buyback = $rab->details->buyback;
	    	if($buyback == 'Not buying this book') {
	    		$buyback = number_format(floatval(0), 2);
	    	} else {
	    		$buyback = (int) $buyback;
	    		$buyback = number_format(floatval($buyback), 2);
	    	}    		
    	} else { $buyback = 0; }


    	//var_dump($rab);


   
    	//$amazon_price = Book::amazon_buyback($book->id);
    	//$buyback_price = number_format($amazon_price - ($amazon_price * .45),2);
    // $prices = 
    // $test = Book::testAmazon();
			return View::make('lookup', array('book' => $book, 'prices' => $prices, 'books' => $books, 'buyback' => $buyback));
		} else {
			return View::make('hello'); 
		} 
	}

	public function viewCart()
	{
	
		$cart = Cart::content();

		return View::make('cart', array('cart' => $cart));
	}

	public function addCartItem()
	{
		$id = Input::get('id');
		$name = Input::get('name');
	//	if ($id) {
	//		$book = Book::find($id)->first();
	//	}
		
		$qty = Input::get('qty');
		$price = Input::get('price');
		$options = array(
										"Title" => Input::get('name'),
										"ISBN10" => Input::get('isbn10'),
										"ISBN13" => Input::get('isbn13'),
										"image_url" => Input::get('image_url'),
										"Publisher" => Input::get('publisher'),
										"Author" => Input::get('author'),
										"Edition" => Input::get('edition')
							 );
		if($id){ Cart::add($id, $name, $qty, $price, $options);}
		return Redirect::to('cart');
	}

	public function removeCartItem()
	{
		$itemId = Input::get('itemId');
		if ($itemId) { Cart::remove($itemId); }
		return Redirect::to('cart');

	}

	public function updateCart()
	{
		$items = Input::get('items');
		foreach($items as $item)
		{
			Cart::update($item['id'], $item['qty']);
		}

		return Redirect::to('cart');
	}
	public function emptyCart()
	{
		Cart::destroy();
		Session::flash('message', '<strong>Cart has been emptied</strong>. Why not add something else?');
		return Redirect::to('/');
	}

	public function checkout(){
		$cart = Cart::content();
		$state_list = array('Alabama'=>"AL", 'Alaska'=>"AK", 'Arizona'=>"AZ", 'Arkansas'=>"AR", 'California'=>"CA", 'Colorado'=>"CO", 'Connecticut'=>"CT", 'Delaware'=>"DE", 'District Of Columbia'=>"DC", 'Florida'=>"FL", 'Georgia'=>"GA", 'Hawaii'=>"HI", 'Idaho'=>"ID", 'Illinois'=>"IL", 'Indiana'=>"IN", 'Iowa'=>"IA", 'Kansas'=>"KS", 'Kentucky'=>"KY", 'Louisiana'=>"LA", 'Maine'=>"ME", 'Maryland'=>"MD", 'Massachusetts'=>"MA", 'Michigan'=>"MI", 'Minnesota'=>"MN", 'Mississippi'=>"MS", 'Missouri'=>"MO", 'Montana'=>"MT", 'Nebraska'=>"NE", 'Nevada'=>"NV", 'New Hampshire'=>"NH", 'New Jersey'=>"NJ", 'New Mexico'=>"NM", 'New York'=>"NY", 'North Carolina'=>"NC", 'North Dakota'=>"ND", 'Ohio'=>"OH", 'Oklahoma'=>"OK", 'Oregon'=>"OR", 'Pennsylvania'=>"PA", 'Rhode Island'=>"RI", 'South Carolina'=>"SC", 'South Dakota'=>"SD", 'Tennessee'=>"TN", 'Texas'=>"TX", 'Utah'=>"UT", 'Vermont'=>"VT", 'Virginia'=>"VA", 'Washington'=>"WA", 'West Virginia'=>"WV", 'Wisconsin'=>"WI", 'Wyoming'=>"WY");
		return View::make('checkout', array('states' => $state_list, 'cart' => $cart));
	}

	public function login(){
		$email = Input::get('email');
		$password = Input::get('password');
		//$user = array(
		//	'email' => Input::get('email'),
		//	'password' => Input::get('password')
		// );
			$user = User::where('email','=',$email)->first();

		if ($password == Crypt::decrypt($user->password)){
				Auth::login($user);
				return Redirect::to('checkout')
					->with('message', 'You are successfully logged in.');
		}

//			return View::make('checkout', array('states' => $state_list, 'cart' => $cart));
		return Redirect::to('checkout')
			->with('message', 'Your email/password combo was not correct, please try again.')
			->withInput();
	}

	public function editprofile(){
			$password = Crypt::decrypt(Auth::user()->password);
			$state_list = array('Alabama'=>"AL", 'Alaska'=>"AK", 'Arizona'=>"AZ", 'Arkansas'=>"AR", 'California'=>"CA", 'Colorado'=>"CO", 'Connecticut'=>"CT", 'Delaware'=>"DE", 'District Of Columbia'=>"DC", 'Florida'=>"FL", 'Georgia'=>"GA", 'Hawaii'=>"HI", 'Idaho'=>"ID", 'Illinois'=>"IL", 'Indiana'=>"IN", 'Iowa'=>"IA", 'Kansas'=>"KS", 'Kentucky'=>"KY", 'Louisiana'=>"LA", 'Maine'=>"ME", 'Maryland'=>"MD", 'Massachusetts'=>"MA", 'Michigan'=>"MI", 'Minnesota'=>"MN", 'Mississippi'=>"MS", 'Missouri'=>"MO", 'Montana'=>"MT", 'Nebraska'=>"NE", 'Nevada'=>"NV", 'New Hampshire'=>"NH", 'New Jersey'=>"NJ", 'New Mexico'=>"NM", 'New York'=>"NY", 'North Carolina'=>"NC", 'North Dakota'=>"ND", 'Ohio'=>"OH", 'Oklahoma'=>"OK", 'Oregon'=>"OR", 'Pennsylvania'=>"PA", 'Rhode Island'=>"RI", 'South Carolina'=>"SC", 'South Dakota'=>"SD", 'Tennessee'=>"TN", 'Texas'=>"TX", 'Utah'=>"UT", 'Vermont'=>"VT", 'Virginia'=>"VA", 'Washington'=>"WA", 'West Virginia'=>"WV", 'Wisconsin'=>"WI", 'Wyoming'=>"WY");
		return View::make('edit_profile', array('states' => $state_list, 'password' => $password));
	}
	public function updateprofile(){
		$user = User::find(Input::get('id'));

		$user->first_name = Input::get('first_name');
		$user->last_name = Input::get('last_name');
		$user->email = Input::get('email');
		$user->password = Crypt::encrypt(Input::get('password'));
		$user->phone = Input::get('phone');
		$user->address = Input::get('address');
		$user->city = Input::get('city');
		$user->state = Input::get('state');
		$user->zip = Input::get('zip');
		$user->payment_method = Input::get('payment_method');
		$user->paypal_email = Input::get('paypal_email');
		$user->save();
		return Redirect::to('edit_profile');
	}
}