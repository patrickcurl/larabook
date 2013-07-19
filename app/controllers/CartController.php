<?php
class CartController extends BaseController {


		public function viewCart()
	{

		$cart = Cart::content();

		return View::make('cart.index', array('cart' => $cart));
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
										"Weight" => Input::get('weight'),
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

		if (Auth::check()){
			return View::make('cart.checkout', array('cart' => $cart));

		} else {
			return View::make('user.login');
		}

	}

		public function checkout_complete(){
		$user = Auth::user();

		$order = new Order;
		$order->user_id = Auth::user()->id;
		$order->total_amount = Cart::total();
		$order->save();


		$cart = Cart::content();
		$weight = 0.0;
		foreach($cart as $item){
			$lineitem = new LineItem;
			$lineitem->book_id = $item->id;
			$lineitem->qty = $item->qty;
			$lineitem->price = $item->price;
			$lineitem->order_id = $order->id;
			$lineitem->save();
			$weight += number_format($item->options->Weight,2);
		}
		$order->ups_label = getLabel($user, $weight);
		$order->save();
		Cart::destroy();
		return Redirect::to('view_orders');

	}
}