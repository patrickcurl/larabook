<?php

class BookController extends BaseController {


	// public function getIndex($slug){

 //    $book = Book::where('slug', '=', $slug)->first();
 //    if($book){

 //    }

 //        $data = Session::get('data');
 //        //return var_dump($data);
 //      return View::make('book.isbn', $data);
 //  }
  public function missingMethod($params)
{
    //return $params;
    return call_user_func_array( array($this, 'getIndex'), $params );
}

    // public function postIsbn(){
    //     $isbn = Input::get('isbn');
    //     $input = array('isbn' => $isbn);
    //     $rules = array('isbn' => "Required|Isbn");
    //     $messages=array();
    //     $v = Validator::make($input, $rules, $messages);
    //     if($v->fails()){
    //         return Redirect::back()->withErrors($v);
    //     } else {
    //         if ($isbn){
    //             // Declarations
    //             $book = Book::find_or_create($isbn);
    //             $books = Book::take(10)->orderBy('updated_at')->get();
    //             $dir = Input::get('dir');
    //             $a = Input::get('a');
    //             $orderby = Input::get('orderby');
    //             if (!$dir){ $dir = 'ASC';}
    //             if (!$orderby){$orderby = "merchant_id";}
    //             $prices = Book::getPrices($book, $orderby, $dir);
    //             $best = Price::getBest($prices);

    //            // $data['add_to_cart'] = View::make('partials.add_to_cart');
    //             $data['prices'] = $prices;
    //             $data['books'] = $books;
    //             $data['book'] = $book;
    //             $data['isbn'] = $isbn;
    //             $data['dir'] = $dir;
    //             $data['orderby'] = $orderby;
    //             $data['activeTab'] = $a;
    //             $data['best'] = $best;
    //                return View::make('lookup', $data);
    //         } else
    //         { return Redirect::back()->with('message', 'No ISBN given.');
    //         }
    //     }
    // }
//     public function getIsbn($isbn=null){
//        if(empty($isbn)){$isbn = Input::get('isbn');}
//       // return var_dump($isbn);
//         $input = array('isbn' => $isbn);
//         $rules = array('isbn' => "Required|Isbn");
//         $messages=array();
//         $v = Validator::make($input, $rules, $messages);
//         if($v->fails()){
//             return Redirect::back()->withErrors($v);
//         } else {
//             if ($isbn){
//                 $book = Book::find_or_create($isbn);
//                 $books = Book::take(10)->orderBy('updated_at')->get();
//                 $dir = Input::get('dir');
//                 $a = Input::get('a');
//                 $orderby = Input::get('orderby');
//                 if (!$dir){ $dir = 'ASC';}
//                 if (!$orderby){$orderby = "merchant_id";}
//                 $prices = Book::getPrices($book, $orderby, $dir);
//                 if ($prices != NULL){
//                     $best = Price::getBest($prices);
//                     // $data['add_to_cart'] = View::make('partials.add_to_cart');
//                     $data['prices'] = $prices;
//                     $data['books'] = $books;
//                     $data['book'] = $book;
//                     $data['isbn'] = $isbn;
//                     $data['dir'] = $dir;
//                     $data['orderby'] = $orderby;
//                     $data['activeTab'] = $a;
//                     $data['best'] = $best;
//                     //return View::make('book.isbn', $data);
//                     //return Redirect::to('/book/' . $book->slug)->with('data', $data);
//                     return Redirect::to('/book/' . $book->slug)->with('data', $data);
//                 } else {
//                     return Redirect::back()->with('message', 'Book not found');
//                 }

//             } else { return Redirect::back()->with('message', 'No ISBN given.'); }

//     }
// }
    public function getIndex($slug=null){
        if (empty($slug)){
            return Redirect::back()->with('message', 'Book not found.');
        } else {
            if ($slug){
                $book = Book::where('slug', '=', $slug)->first();
                $books = Book::take(10)->orderBy('updated_at')->get();
                $dir = Input::get('dir');
                $a = Input::get('a');
                $orderby = Input::get('orderby');
                if (!$dir){ $dir = 'ASC';}
                if (!$orderby){$orderby = "merchant_id";}
                $prices = Book::getPrices($book, $orderby, $dir);
                if(isset($prices) && $prices != null){
                    $data['prices'] = $prices;
                    $data['books'] = $books;
                    $data['book'] = $book;
                    $data['isbn'] = Session::get('isbn');
                    $data['dir'] = $dir;
                    $data['orderby'] = $orderby;
                    $data['activeTab'] = $a;
                    //$data['best'] = $best;
                    return View::make('book.isbn', $data);

                } else {
                    Redirect::back()->with('message', 'Book not found.');
                }
            } else {
                Redirect::back()->with('message', 'Book not found.');
            }
        }
    }
    public function getIsbn($isbn=null){
        if(empty($isbn)){
            $isbn = Input::get('isbn');
            if (empty($isbn)){
                return Redirect::back()->with('message', 'Please enter an ISBN!');
            } else {
                if(strlen($isbn) == 10 || strlen($isbn) ==13){
                    $book = Book::find_or_create($isbn);
                    if(isset($book) && $book!= null){
                        return Redirect::to('/books/' . $book->slug)->with('isbn', $isbn);
                    }
                } else {
                    return Redirect::back()->with('message', 'Invalid ISBN : Must be 10 or 13 characters.');
                }
            }
        }
    }
/*	public function getLookup()
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


			return View::make('lookup', array('book' => $book, 'prices' => $prices, 'books' => $books, 'buyback' => $buyback));
		} else {
			return View::make('hello');
		}

}*/


















}