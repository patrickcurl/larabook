<?php
class OrdersController extends BaseController {


public function view_orders(){
		if(!Auth::check()){
			return Redirect::to('login')->with('message', 'Must be logged in to view page.');
		} else {

			$orders = Order::where('user_id','=',Auth::user()->id)->get(); // find all orders from currently logged in user.
			$orderArray = array(); // init order array
			$i = 0;
			//Put all orders into arrays for easy enumeration.
			foreach($orders as $order){
				$items = DB::table('items')->join('books', function($join){$join->on('books.id', '=', 'items.book_id');})->where('order_id','=',$order->id)->get();
				$orderArray[$i]['id'] = $order->id;
				$orderArray[$i]['total_amount'] = $order->total_amount;
				$orderArray[$i]['created_at'] = $order->created_at;
				$orderArray[$i]['received_date'] = $order->received_date;
				$orderArray[$i]['paid_date'] = $order->paid_date;
				$orderArray[$i]['comments'] = $order->comments;
				//$orderArray[$i]['ups_label'] = $order->ups_label;
				$j = 0;
					// attach all items to an order
				foreach($items as $item){
					$orderArray[$i]['items'][$j]['qty'] = $item->qty;
					$orderArray[$i]['items'][$j]['price'] = $item->price;
					$orderArray[$i]['items'][$j]['title'] = $item->title;
					$orderArray[$i]['items'][$j]['author'] = $item->author;
					$orderArray[$i]['items'][$j]['edition'] = $item->edition;
					$orderArray[$i]['items'][$j]['image_url'] = $item->image_url;
					$orderArray[$i]['items'][$j]['publisher'] = $item->publisher;
					$orderArray[$i]['items'][$j]['isbn10'] = $item->isbn10;
					$orderArray[$i]['items'][$j]['isbn13'] = $item->isbn13;
				$j++;
				}

					$i++;
			}
				return View::make('user.view_orders', array('orders' => $orderArray));
		}
}

	public function getLabel($id){
		$order = Order::find($id)->first();

		return View::make('orders.label', array('ups_label' => $order->ups_label));
	}

	public function getPackingSlip($id){
		$order = Order::find($id);
		$items = DB::table('items')->join('books', function($join){$join->on('books.id', '=', 'items.book_id');})->where('order_id','=',$id)->get();

		return View::make('orders.packingslip', array('items' => $items, 'orderTotal' => $order->total_amount));
	}

}

