<?php

class BooksController extends BaseController {


	public function getBook($id){
    $book = Book::where('slug', '=', $id); 
    return var_dump($book);
  }

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


















}