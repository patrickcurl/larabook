<?php
class Book extends Eloquent {
	private $isbn;
	protected $table = 'books';
	protected $fillable = array('title', 'author', 'publisher', 'image_url', 'isbn10', 'isbn13', 'amazon_url', 'edition', 'num_of_pages', 'list_price');


	public function prices(){
		return $this->hasMany('Price');
		
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
			$xml_b = $xml_a->asXML();
			Cache::add("{$merch}{$isbn}", $xml_b, 400);
			return $xml_a;
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
		

			// $response = simplexml_load_file(amazonURL($isbn));
			$response = self::cache_xml($isbn, 'amazon', amazonURL($isbn));
			var_dump($response->Items->Item->ItemAttributes->ListPrice->FormattedPrice);

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

			$book->save();
			return $book;
			
		}

		
	
		
	}




	public static function newPrice($book, $merchant, $type, $buy_url, $amount){
		$price = Price::where('merchant_id','=',$merchant->id)->where('book_id','=',$book->id)->first();
		
		if ($price) {
		//	$updated_at = new DateTime($price->updated_at);
		//	$compare_time = new DateTime( date("Y-m-d H:i:s"));
		//	$interval = $updated_at->diff($compare_time);
		//	if ($interval->h>6){
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
			$price->save();
			//$price = $book->prices()->save($price);
		}
		
		return $price;
		
	}

	public static function getPrices($book){
    $isbn = $book->isbn13;


		//$isbn = Input::get('isbn');
		var_dump($isbn);
		$xml_valore = self::cache_xml($isbn, "valore", "http://prices.valorebooks.com/lookup-multiple-categories?SiteID=s1pI8Z&ProductCode=$isbn");
		$xml_amazon = self::cache_xml($isbn, "amazon", amazonURL($isbn));
		//var_dump($response);
		//$amazonXML = amazonXML($isbn);
		//$amazonXML->registerXpathNamespace("xmlns", "http://webservices.amazon.com/AWSECommerceService/2011-08-01"); 
		# $biggerbooksXML = simplexml_load_string(file_get_contents("http://www.biggerbooks.com/botpricexml?isbn=$isbn"));
		# $valorebooksXML = simplexml_load_string(file_get_contents("http://prices.valorebooks.com/lookup-multiple-categories?SiteID=s1pI8Z&ProductCode=$isbn"));
		
		
		// $valore = Cache::remember("valore{$isbn}", 360, function(){
		//	$valoreXML = @simplexml_load_file("http://prices.valorebooks.com/lookup-multiple-categories?SiteID=s1pI8Z&ProductCode=$isbn")->asXML();
		//	return $valoreXML;
		// });
/*	if(Cache::has("valore{$isbn}")){
			$valore = Cache::get("valore{$isbn}");
			$valoreXML = new SimpleXMLElement($valore);
			echo var_dump($valoreXML) . "<br />";
			echo "<br /><br /><br /><br />TEST<br /><br />" . var_dump($valoreXML->{'sale-offer'}->price);
		} else {
			var_dump($test);
			$valoreXML = @simplexml_load_file("http://prices.valorebooks.com/lookup-multiple-categories?SiteID=s1pI8Z&ProductCode=$isbn");
			$valoreXML = $valoreXML->asXML();
			Cache::add("valore{$isbn}", $valoreXML, 400);
			echo var_dump($valoreXML);
		}
*/
		//var_dump($valoreXML);

		# $ecampusXML = simplexml_load_string(file_get_contents("http://www.ecampus.com/botpricexml.asp?isbn=$isbn"));

		$merchants = Merchant::all();

		$merchant = array(); 
		foreach($merchants as $m){
			$merchant[$m->slug] = $m;
			}
		$amazonPrices = array(
      'new' => array(
      								//		'price' =>number_format((xmlParse('//xmlns:OfferSummary/xmlns:LowestNewPrice/xmlns:Amount', $amazonXML) / 100), 2),
      									'price' => number_format($xml_amazon->Items->Item->OfferSummary->LowestNewPrice->Amount / 100, 2),
      										'url' => $xml_amazon->Items->Item->DetailPageURL
										),
      'used'=> array(
      										//'price' =>number_format((xmlParse('//xmlns:OfferSummary/xmlns:LowestUsedPrice/xmlns:Amount', $amazonXML) / 100), 2), 
      										'price' => number_format($xml_amazon->Items->Item->OfferSummary->LowestUsedPrice->Amount / 100, 2),
      										//'url' => xmlParse('//xmlns:Offers/xmlns:MoreOffersUrl', $amazonXML)
      										'url' => $xml_amazon->Items->Item->Offers->MoreOffersUrl
      										),
      'rental' => array(
      										'price' =>'', 
      										'url' => ''
      									),
      'ebook' => array(	
      										'price' =>'', 
      										'url' => ''
      								),
      'buyback'=>array(
	      								//'price' =>number_format((xmlParse('//xmlns:TradeInValue/xmlns:Amount', $amazonXML) / 100), 2),
	      								'price' => number_format($xml_amazon->Items->Item->OfferSummary->TradeInValue->Amount / 100, 2),
	      								'url' => $xml_amazon->Items->Item->DetailPageURL
      								//		'url' =>xmlParse('//xmlns:Item/xmlns:DetailPageURL', $amazonXML)
      							) 
      	);
var_dump($amazonPrices);

		//self::newPrice($book, $merchant['amazon'], $amazonPrices)
 		self::newPrice($book, $merchant['amazon'], 'new', $amazonPrices['new']['url'], $amazonPrices['new']['price']);
		self::newPrice($book, $merchant['amazon'], 'used', $amazonPrices['used']['url'], $amazonPrices['used']['price']);
		self::newPrice($book, $merchant['amazon'], 'buyback', $amazonPrices['buyback']['url'], $amazonPrices['buyback']['price']);
		//return $ecampusXML;

  //  $book = Book::find_or_create($isbn);
    
  //  return $book;
		//	$prices = Price::where('book_id','=',$book->id)->orderBy('amount', 'asc')->get();
		//	return $prices;
		//$prices = Book::find($book->id)->merchants()->get();
		$prices = Book::find($book->id)->prices()->get();
		return $prices;
  }

}
