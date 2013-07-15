<?php 
class OrdersController extends BaseController {


public function view_orders(){
		if(Auth::check()){
				$orders = Order::where('user_id','=',Auth::user()->id)->get();
				$orderArray = array();
				$i = 0;
				foreach($orders as $order){
					$lineitems = DB::table('lineitems')->join('books', function($join){$join->on('books.id', '=', 'lineitems.book_id');})->where('order_id','=',$order->id)->get();
					$orderArray[$i]['total_amount'] = $order->total_amount;
					$orderArray[$i]['created_at'] = $order->created_at;
					$orderArray[$i]['shipment_received'] = $order->shipment_received;
					$orderArray[$i]['payment_sent'] = $order->payment_sent;
					$orderArray[$i]['comments'] = $order->comments;
					$j = 0;
					foreach($lineitems as $item){
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
					// var_dump($orderArray);
					$i++;
				}

			 	return View::make('user.view_orders', array('orders' => $orderArray));
		} else {Redirect::to('/login')->with('message', 'Must be logged in to see that page.');}
		

	}

	public function print_label(){
		return View::make('print_label');
	}

}