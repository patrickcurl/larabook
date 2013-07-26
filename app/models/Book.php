<?php
class Book extends Eloquent {
	private $isbn;
	protected $table = 'books';
	protected $fillable = array('title', 'author', 'publisher', 'image_url', 'isbn10', 'isbn13', 'amazon_url', 'edition', 'num_of_pages', 'list_price');


	public function prices(){
		return $this->hasMany('Price');

	}

	public function lineitems(){
		return $this->belongsToMany('LineItems', 'lineitems', 'book_id');
	}


	public function merchants(){
		return $this->belongsToMany('Merchant', 'prices');
	}

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
			$book->list_price = number_format($response->Items->Item->ItemAttributes->ListPrice->FormattedPrice / 100, 2) ;
			$book->weight = number_format($response->Items->Item->ItemAttributes->ItemDimensions->Weight /100, 2);
			$book->save();
			return $book;

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

	public static function getPrices($book, $orderby, $dir){
    $isbn = $book->isbn13;
		$xml_valore = self::cache_xml($isbn, "valore", "http://prices.valorebooks.com/lookup-multiple-categories?SiteID=s1pI8Z&ProductCode=$isbn");
		$xml_amazon = self::cache_xml($isbn, "amazon", amazonURL($isbn));
		$xml_bookrenter = self::cache_xml($isbn, 'bookrenter', "http://www.bookrenter.com/api/fetch_book_info?developer_key=QDz1rdEMKgvnuqIvD1hsRhparmZ6L0Z8&version=2011-02-01&isbn=$isbn");
		$xml_biggerbooks = self::cache_xml($isbn, 'biggerbooks', "http://www.biggerbooks.com/botpricexml?isbn=$isbn");
		$xml_ecampus = self::cache_xml($isbn, 'ecampus', "http://www.ecampus.com/botpricexml.asp?isbn=$isbn");
		$xml_recycleabook = self::cache_xml($isbn, 'recycleabook', "http://www.recycleabook.com/search_isbn.php?isbn=$isbn");
		//	$xml_campusbookrentals = self::cache_xml($isbn, 'campusbookrentals', "http://services.campusbookrentals.com/RentPrice/$isbn?responseformat=XML&apikey=4b2764ec-f471-4948-964b-864401fc3e7e")
		$xml_chegg = self::cache_xml($isbn, 'chegg', "http://api.chegg.com/rent.svc?KEY=4df15ef34c0834a6eb0f6bae902d5bc8&PW=9514815&R=XML&V=2.0&isbn=$isbn&with_pids=1");
		//$xml_betterworldbooks = self::cache_xml($isbn, 'betterworldbooks');
		$merchants = Merchant::all();

		$merchant = array();
		foreach($merchants as $m){
			$merchant[$m->slug] = $m;
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

	if ($xml_bookrenter){
		if ($xml_bookrenter->book->availability != "Backordered"){
			$br_link = "http://www.dpbolvw.net/click-7171865-10920299?url=" . urlencode($xml_bookrenter->book->book_url);
			$br_new_price = $xml_bookrenter->xpath("//purchase_price[contains(@condition, 'new')]");
			if($br_new_price){
				$br_new_price = floatval(ltrim($br_new_price[0], "$"));
				self::newPrice($book, $merchant['bookrenter'], 'new', $br_link, $br_new_price);
			}

			$br_used_price = $xml_bookrenter->xpath("//purchase_price[contains(@condition, 'used')]");
			if($br_used_price){
				$br_used_price = floatval(ltrim($br_used_price[0], "$"));
				self::newPrice($book, $merchant['bookrenter'], 'used', $br_link, $br_used_price);
			}

			$br_rental_price = $xml_bookrenter->xpath("//rental_price[contains(@days, '90')]");
			if($br_rental_price){
				$br_rental_price = floatval(ltrim($br_rental_price[0], "$"));
				self::newPrice($book, $merchant['bookrenter'], 'rental', $br_link, $br_rental_price);
			}


		}




		//Commission Junction baseurl: http://www.dpbolvw.net/click-7171865-10920299?url=



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

//	if ($xml_campusbookrentals){
//
//	}

		if ($xml_chegg){
			$ref = "CJGATEWAY";
			//$pid = $xml_chegg->
			$nodes = $xml_chegg->xpath("//Terms/Term/Term[.='SEMESTER']/parent::*");
			$result = $nodes[0];
			$pid = $result->Pid;
			$chegg_base_link = urlencode("http://www.chegg.com/?referrer=CJGATEWAY&&PID=7205117&AID=10692263&pids=$pid");
			$chegg_aff_link = "http://www.jdoqocy.com/click-7205117-10692263?URL=$chegg_base_link";
			$chegg_price = $result->Price;
			self::newPrice($book, $merchant['chegg'], 'rental', $chegg_base_link, $chegg_price);
		}
		$prices = Book::find($book->id)->prices()->orderBy($orderby, $dir)->get();
		return $prices;
  }

  public static function amazon_buyback($id){
  	$price = Book::find($id)->prices()->where('merchant_id', '=', 2)->first();
  	$price = $price->amount_buyback;
  	$price = number_format($price, 2);
  	return $price;

  }


}