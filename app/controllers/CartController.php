<?php 
class CartController extends BaseController {
	

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
										"book_id" => Input::get('id'),
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

		public function checkout_complete(){

		$order = new Order;
		$order->user_id = Auth::user()->id;
		$order->total_amount = Cart::total();
		$order->save();

		$cart = Cart::content();

		foreach($cart as $item){
			$lineitem = new LineItem;
			$lineitem->book_id = $item->id;
			$lineitem->qty = $item->qty;
			$lineitem->price = $item->price;
			$lineitem->order_id = $order->id;
			$lineitem->save();
		}
		Cart::destroy();
		return Redirect::to('/');

	}
}