<?php
class Book extends Eloquent {
	private $isbn;
	protected $table = 'books';
	protected $fillable = array('title', 'author', 'publisher', 'image_url', 'isbn10', 'isbn13', 'amazon_url', 'edition', 'num_of_pages', 'list_price');


	public function prices(){
		return $this->hasMany('Price');

	}

	public function items(){
		return $this->belongsToMany('Item', 'items', 'book_id');
	}


	public function merchants(){
		return $this->belongsToMany('Merchant', 'prices');
	}

	public static $sluggable = array(
        'build_from' => 'title',
        'save_to'    => 'slug',
    );

	public static function cache_xml($isbn, $merch, $url){
		if(Cache::has("{$merch}{$isbn}")){
			$xml = Cache::get("{$merch}{$isbn}");
			$xml = new SimpleXMLElement($xml);
			return $xml;
		} else {
			$xml_a = @simplexml_load_file($url);
			if ($xml_a){
				$xml_b = $xml_a->asXML();
				Cache::add("{$merch}{$isbn}", $xml_b, 400);
				return $xml_a;
			} else {
				return NULL;
			}

		}

	}


	public static function find_or_create($isbn){
		// $amazon = amazonXML($isbn);
		$book = Book::where('isbn10', '=', $isbn)
											->orWhere('isbn13', '=', $isbn)
											->first();
		if ($book){
			return $book;
		} else {
			$response = self::cache_xml($isbn, 'amazon', amazonURL($isbn));
			$response->registerXpathNamespace("xmlns", "http://webservices.amazon.com/AWSECommerceService/2011-08-01");
			$n = $response->xpath('//xmlns:BrowseNode/xmlns:Name');
			$a_error = $response->xpath('//xmlns:Errors/xmlns:Error');
			if(empty($a_error)){
				// return var_dump($a_error);
				$book = new Book();
				$book->isbn10 = $response->Items->Item->ASIN;
				$book->isbn13 = $response->Items->Item->ItemAttributes->EAN;
				$book->title = $response->Items->Item->ItemAttributes->Title;
				$book->author = $response->Items->Item->ItemAttributes->Author;
				$book->publisher = $response->Items->Item->ItemAttributes->Publisher;
				$book->edition = $response->Items->Item->ItemAttributes->Edition;
				$book->image_url = $response->Items->Item->LargeImage->URL;
				$book->amazon_url = $response->Items->Item->DetailPageURL;
				$book->num_of_pages = $response->Items->Item->ItemAttributes->NumberOfPages;
				$book->list_price = $response->Items->Item->ItemAttributes->ListPrice->FormattedPrice;
				$book->weight = number_format($response->Items->Item->ItemAttributes->ItemDimensions->Weight /100, 2);
				$book->editorial_review = $response->Items->Item->EditorialReview->Content;
				$book->customer_reviews = $response->Items->Item->CustomerReviews->IFrameURL;
				$book->save();

				$categories = $response->xpath('//xmlns:BrowseNode/xmlns:Name');
				$categories = array_unique($categories);
				foreach($categories as $cat){
					$category = Category::where('name', '=', $cat)->first();
					if ($category){
						// category already exists attach it to book.
						DB::table('books_categories')->insert(
								array('book_id' => $book->id, 'category_id' => $category->id)
							);
					} else {
						// category doesn't exist, create it then attach it to book.
						$category = new Category();
						$category->name = $cat;
						$category->save();

						DB::table('books_categories')->insert(
								array('book_id' => $book->id, 'category_id' => $category->id)
							);
					}
			}
			} else { return Null; }
		}
			if ($book){
				return $book;
			} else {
				return Null;
			}
	}





	public static function newPrice($book, $merchant, $type, $buy_url, $amount){
		//function to update or add new price.
		$price = Price::where('merchant_id','=',$merchant->id)->where('book_id','=',$book->id)->first();
		// grabs price object for current book/merchant pairing if exists.

		if ($price) {
			// if price exists update the db w/ the new price depending on the $type variable using switch case.
				switch($type){
					case 'new' :
						$price->amount_new = $amount;
						$price->url_new = $buy_url;
						break;
					case 'used' :
						$price->amount_used = $amount;
						$price->url_used = $buy_url;
						break;
					case 'rental' :
						$price->amount_rental = $amount;
						$price->url_rental = $buy_url;
						break;
					case 'ebook' :
						$price->amount_ebook = $amount;
						$price->url_ebook = $buy_url;
						break;
					case 'buyback' :
						$price->amount_buyback = $amount;
						$price->url_buyback = $buy_url;
						break;
				}
				$price->save();

		} else {
			// if price doesn't exist do same as above, only instead create a new price row in db,
			// choose field to update based on $type.
			$price = new Price(array('book_id' => $book->id, 'merchant_id' => $merchant->id));
			switch($type){
				case 'new' :
					$price->amount_new = $amount;
					$price->url_new = $buy_url;
					break;
				case 'used' :
					$price->amount_used = $amount;
					$price->url_used = $buy_url;
					break;
				case 'rental' :
					$price->amount_rental = $amount;
					$price->url_rental = $buy_url;
					break;
				case 'ebook' :
					$price->amount_ebook = $amount;
					$price->url_ebook = $buy_url;
					break;
				case 'buyback' :
					$price->amount_buyback = $amount;
					$price->url_buyback = $buy_url;
					break;
			}
			$price->save(); // save the changes to db.
 			}

		$priceArr = array(
			'price' => number_format($amount / 100, 2),
			'url' => $buy_url
			);
		return $priceArr; // returns the price/url as an array for display to user.

	}

	public static function getPowells($isbn){
		$curl = New Curl;
		$curl->create("http://www.powells.com/search/linksearch?isbn=$isbn");
		$curl->option('buffersize', 20);
		$p_items = $curl->execute();
		$p_items = str_replace("<HTML><BODY><PRE>\n", "", $p_items);
		$p_items = str_replace("\n\n</PRE>", "", $p_items);
		$p_items = str_replace("</PRE>", "", $p_items);
		$p_items = str_replace("Notes:\n", "", $p_items);
		if (empty($p_items)){return null;} else {
	 		$p_items = explode("\n\n", strip_tags($p_items));
			$items = array();
			foreach($p_items as $key=>$value){
			  $value = explode("\n", $value);

			  foreach($value as $val){
			    $parts = explode(": ", $val, 2);

			    if (sizeof($parts > 1)){
			     $items[$key][$parts[0]] = $parts[1];
			    }
			  }
			}

			foreach ($items as $t){
			  if ($t['Class'] == "NEW"){
			    if(!isset($newPrice)){
			    	$newPrice = $t['Price'];
			      $newBinding = str_replace(" ", "%20", $t['Binding']);
			    } else {
			      if ($t['Price'] < $newPrice){
			        $newPrice = $t['Price'];
			        $newBinding = str_replace(" ", "%20", $t['Binding']);
			      }
			    }
			 }
	    if ($t['Class'] == "USED"){
	      if(!isset($usedPrice)){
	        $usedPrice = $t['Price'];
	      	$usedBinding = str_replace(" ", "%20", $t['Binding']);
	      } else {
	        if ($t['Price'] < $usedPrice){
	          $usedPrice = $t['Price'];
	          $usedBinding = str_replace(" ", "%20", $t['Binding']);
	        }
	      }
	    }
	  }

	  $prices = array();
		// example url : http://www.powells.com/cgi-bin/partner?partner_id=XXX&cgi=biblio&show=TRADE%20PAPER:NEW:0140237208:15.00
		$aff_id = Config::get('env_vars.aff_id_powells');
		if(isset($newPrice) && isset($newBinding)){$newUrl = 'http://www.powells.com/cgi-bin/partner?partner_id=' . $aff_id . '&cgi=biblio&show=' . $newBinding . ':NEW:' . $isbn . ':' . $newPrice;
			$new = array('url' => $newUrl, 'price' => $newPrice, 'binding' => $newBinding);
			$prices['new'] = $new;
		}
		if(isset($usedPrice) && isset($usedBinding)){$usedUrl = 'http://www.powells.com/cgi-bin/partner?partner_id=' . $aff_id . '&cgi=biblio&show=' . $usedBinding . ':NEW:' . $isbn . ':' . $usedPrice;
			$used = array('url' => $usedUrl, 'price' => $usedPrice, 'binding' => $usedBinding);
			$prices['used'] = $used;
	}



		//$prices = array("new" => $new, "used" => $used);
		return $prices;
 }
}

	public static function curlPrice($url, $pathStart, $pathEnd, $tag /*, $xpath, $options */){
		$curl = New Curl;
		$curl->create($url);
		$curl->option('buffersize', 20);
		$curl->option('timeout', 60);
		$curl->option('returntransfer', true);
		$html = $curl->execute();

		$charBegin = stripos($html, $pathStart); // path= <p class="price"
		if($charBegin){
		  $htmlList = substr($html, $charBegin, strlen($html));
		  $charLast = stripos($htmlList, $pathEnd);
		  $htmlList=substr($htmlList, 0, $charLast+4);
		  //return $htmlList;
		  $o = @DomDocument::loadHTML($htmlList);
		  $p = $o->getElementsByTagName($tag);
		  $price = $p->item(0)->nodeValue;
		  $price = str_replace('$', '', $price);
		  return $price;
		} else {
			return Null;
		}

	}



	public static function getPrices($book, $orderby="amount_used", $dir="DESC"){
    	if ($book){
    		$isbn = $book->isbn13;
		$xml_valore = self::cache_xml($isbn, "valore", "http://prices.valorebooks.com/lookup-multiple-categories?SiteID=s1pI8Z&ProductCode=$isbn");
		$xml_amazon = self::cache_xml($isbn, "amazon", amazonURL($isbn));
		$xml_bookrenter = self::cache_xml($isbn, 'bookrenter', "http://www.bookrenter.com/api/fetch_book_info?developer_key=QDz1rdEMKgvnuqIvD1hsRhparmZ6L0Z8&version=2011-02-01&isbn=$isbn");
		$xml_biggerbooks = self::cache_xml($isbn, 'biggerbooks', "http://www.biggerbooks.com/botpricexml?isbn=$isbn");
		$xml_ecampus = self::cache_xml($isbn, 'ecampus', "http://www.ecampus.com/botpricexml.asp?isbn=$isbn");
		$xml_recycleabook = self::cache_xml($isbn, 'recycleabook', "http://www.recycleabook.com/search_isbn.php?isbn=$isbn");
		$xml_campusbookrentals = self::cache_xml($isbn, 'campusbookrentals', "http://services.campusbookrentals.com/RentPrice/$isbn?responseformat=XML&apikey=4b2764ec-f471-4948-964b-864401fc3e7e");
		// Example link: http://www.kqzyfj.com/click-7205117-10722272?url=http://www.campusbookrentals.com/textbook/9780073379203
		$xml_chegg = self::cache_xml($isbn, 'chegg', "http://api.chegg.com/rent.svc?KEY=4df15ef34c0834a6eb0f6bae902d5bc8&PW=9514815&R=XML&V=2.0&isbn=$isbn&with_pids=1");


		$powells = self::getPowells($isbn);
		$sellbackbooks = self::curlPrice("http://www.sellbackbooks.com/bbsearchresult.aspx?ISBN=$isbn", "<p class=\"price\"", "</p>", "p");
		$buyback101 = self::curlPrice("http://www.buyback101.com/bb101api.php?a=".Config::get('env_vars.bb101_aff')."&akey=".Config::get('env_vars.bb101_key')."&isbn=$isbn&view=price", "<price>", "</price>", "price");
		//$xml_betterworldbooks = self::cache_xml($isbn, 'betterworldbooks');
		$merchants = Merchant::all();

		$merchant = array();
		foreach($merchants as $m){
			$merchant[$m->slug] = $m;
			}
		if ($xml_recycleabook){
			self::newPrice($book, $merchant["recycleabook"], "buyback", "http://www.recycleabook.com/isbn-results/?isbn=9780131367739", $xml_recycleabook->details->buyback);
		}
		if ($buyback101) {
			$bb101link = "http://www.buyback101.com/bb101api.php?a=".Config::get('env_vars.bb101_aff')."&akey=".Config::get('env_vars.bb101_key')."&isbn=$isbn&view=link";
			self::newPrice($book, $merchant["buyback101"], "buyback",  $bb101link, number_format($buyback101, 2));
		}

		if ($sellbackbooks){
			$sbbbuylink = "http://www.shareasale.com/r.cfm?B=186456&U=421178&M=13388&urllink=www.sellbackbooks.com/bbsearchresult.aspx?ISBN=$isbn";
			self::newPrice($book, $merchant["sellbackbooks"], "buyback",  $sbbbuylink, number_format($sellbackbooks, 2));
		}

		if ($xml_amazon){
			self::newPrice($book, $merchant['amazon'], 'new', $xml_amazon->Items->Item->DetailPageURL, number_format($xml_amazon->Items->Item->OfferSummary->LowestNewPrice->Amount/100,2));
			self::newPrice($book, $merchant['amazon'], 'used', $xml_amazon->Items->Item->Offers->MoreOffersUrl, number_format($xml_amazon->Items->Item->OfferSummary->LowestUsedPrice->Amount/100,2));
			self::newPrice($book, $merchant['amazon'], 'buyback', $xml_amazon->Items->Item->DetailPageURL, number_format($xml_amazon->Items->Item->ItemAttributes->TradeInValue->Amount/100,2));
		}

		if ($xml_valore){
			self::newPrice($book, $merchant['valore'], 'used', $xml_valore->{'sale-offer'}->link, $xml_valore->{'sale-offer'}->price);
			self::newPrice($book, $merchant['valore'], 'rental', $xml_valore->{'rental-offer'}->link, $xml_valore->{'rental-offer'}->{'semester-price'});
		}

		// If the xml worked and we have a bookrenter object
		if ($xml_bookrenter){
			//Check if book is backordered.
			if ($xml_bookrenter->book->availability != "Backordered"){
				$br_link = "http://www.dpbolvw.net/click-7171865-10920299?url=" . urlencode($xml_bookrenter->book->book_url);

				$br_new_price = $xml_bookrenter->xpath("//purchase_price[contains(@condition, 'new')]");
				// Check if we have a new price.
				if($br_new_price){
					$br_new_price = floatval(ltrim($br_new_price[0], "$"));
					self::newPrice($book, $merchant['bookrenter'], 'new', $br_link, $br_new_price);
				} //End check if $br_new_price exists

				$br_used_price = $xml_bookrenter->xpath("//purchase_price[contains(@condition, 'used')]");
				// Check if we have a used price.
				if(!empty($br_used_price[0])){
					$br_used_price = floatval(ltrim($br_used_price[0], "$"));
					self::newPrice($book, $merchant['bookrenter'], 'used', $br_link, $br_used_price);
				} //End check if $br_used_price exists

				$br_rental_price = $xml_bookrenter->xpath("//rental_price[contains(@days, '90')]");
				// Check if we have a rental price.
				if($br_rental_price){
					$br_rental_price = floatval(ltrim($br_rental_price[0], "$"));
					self::newPrice($book, $merchant['bookrenter'], 'rental', $br_link, $br_rental_price);
				} //End check if $br_rental_price exists
			} // End Check if availability is not Backordered.
				//Commission Junction baseurl: http://www.dpbolvw.net/click-7171865-10920299?url=
		}

		if ($powells){
			if(isset($powells['used'])){
				if($powells['used']['price'] > 0.01){
					if (!empty($powells['used']['url'])){
						self::newPrice($book, $merchant['powells'], 'used', $powells['used']['url'], $powells['used']['price']);
					}
				}
			}
			if(isset($powells['new'])){
				if($powells['new']['price'] > 0.01){
					if (!empty($powells['new']['url'])){
						self::newPrice($book, $merchant['powells'], 'new', $powells['new']['url'], $powells['new']['price']);
					}
				}
			}
		}

		if ($xml_biggerbooks){
			$bb_url = "http://www.dpbolvw.net/click-7171865-9467039?isbn=$isbn";
			$bb_new = floatval(ltrim($xml_biggerbooks->NewPrice, "$"));
			$bb_used = floatval(ltrim($xml_biggerbooks->UsedPrice, "$"));
			$bb_ebook = floatval(ltrim($xml_biggerbooks->eBookPrice, "$"));
			self::newPrice($book, $merchant['biggerbooks'], 'new', $bb_url, $bb_new);
			self::newPrice($book, $merchant['biggerbooks'], 'used', $bb_url, $bb_used);
			self::newPrice($book, $merchant['biggerbooks'], 'ebook', $bb_url, $bb_ebook);
		}

		if ($xml_campusbookrentals){
			$cbr_url = urlencode("http://www.kqzyfj.com/click-7205117-10722272?url=http://www.campusbookrentals.com/textbook/$isbn");
			$cbr_rental = ($xml_campusbookrentals->PriceResult->PriceSemester);
			self::newPrice($book, $merchant['campusbookrentals'], 'rental', $cbr_url, $cbr_rental);
		}

		if ($xml_chegg){
			$ref = "CJGATEWAY";
			//$pid = $xml_chegg->
			$nodes = $xml_chegg->xpath("//Terms/Term/Term[.='SEMESTER']/parent::*");
			if ($nodes){$result = $nodes[0];
				$pid = $result->Pid;
				$chegg_base_link = urlencode("http://www.chegg.com/?referrer=CJGATEWAY&&PID=7205117&AID=10692263&pids=$pid");
				$chegg_aff_link = "http://www.jdoqocy.com/click-7205117-10692263?URL=$chegg_base_link";
				$chegg_price = $result->Price;
			self::newPrice($book, $merchant['chegg'], 'rental', $chegg_base_link, $chegg_price);
			}


		}
		$prices = DB::table('prices')
                ->join('merchants', function($join){
                  $join->on('prices.merchant_id', '=', 'merchants.id');
                })->where('prices.book_id', '=', $book->id)->get();
		return $prices;
    	} else {
    		return NULL;
    	}

  }

  public static function amazon_buyback($id){
  	$price = Book::find($id)->prices()->where('merchant_id', '=', 2)->first();
  	$price = $price->amount_buyback;
  	$price = number_format($price, 2);
  	return $price;

  }


}