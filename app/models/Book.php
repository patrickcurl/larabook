<?php
require_once('aws_signed_request.php');
require_once('simple_html_dom.php');
require_once('functions.php');

class Book extends Eloquent {
	private $isbn;
	protected $table = 'books';
	protected $fillable = array('title', 'author', 'publisher', 'image_url', 'isbn10', 'isbn13', 'amazon_url', 'edition', 'num_of_pages', 'list_price');


	public function prices(){
		$this->hasMany('Price');
	}
	public static function find_or_create($isbn){
		$amazon = amazonXML($isbn);
		$book = Book::where('isbn10', '=', $isbn)
											->orWhere('isbn13', '=', $isbn)
											->first();
	if ($book){
			return $book;
		} else {
			$bookData = self::getBookData($isbn, $amazon);
			$book = new Book();
			$book->isbn10 = $bookData['isbn10'];
 			$book->isbn13 = $bookData['isbn13'];
			$book->title = $bookData['title'];
			$book->author = $bookData['author'];
			$book->publisher = $bookData['publisher'];
			$book->edition = $bookData['edition'];
			$book->image_url = $bookData['image_url'];
			$book->amazon_url = $bookData['amazon_url'];
			$book->num_of_pages = $bookData['num_of_pages'];
			$book->list_price = $bookData['list_price'];
			$book->save();
			return $book;
		}

		
	
		
	}

	protected static function getBookData($isbn, $xml){
		// $xml = amazonXML($isbn);
		// $xml->registerXpathNamespace("xmlns", "http://webservices.amazon.com/AWSECommerceService/2011-08-01"); 
	
		$bookdata = array(
					"isbn10" => xmlParse('//xmlns:Items/xmlns:Item/xmlns:ASIN', $xml),
					"isbn13" => xmlParse('//xmlns:ItemAttributes/xmlns:EAN', $xml),
					"title" => xmlParse('//xmlns:ItemAttributes/xmlns:Title', $xml),
					"author" => xmlParse('//xmlns:ItemAttributes/xmlns:Author', $xml),
					"publisher" => xmlParse('//xmlns:ItemAttributes/xmlns:Publisher', $xml),
					"edition" => xmlParse('//xmlns:ItemAttributes/xmlns:Edition', $xml),
					"amazon_url" => xmlParse('//xmlns:DetailPageURL', $xml),
					"image_url" => xmlParse('//xmlns:LargeImage/xmlns:URL', $xml),
					"list_price" => xmlParse('//xmlns:ItemAttributes/xmlns:ListPrice/xmlns:Amount', $xml),
					"num_of_pages" => xmlParse('//xmlns:NumberOfPages', $xml)
					);
		return $bookdata;
	}


	public static function newPrice($book, $merchant, $type, $buy_url, $amount){
		$price = Price::where('merchant_id','=',$merchant->id)->where('type','=', $type)->where('book_id','=',$book->id)->first();
		
		if ($price) {
			$updated_at = new DateTime($price->updated_at);
			$compare_time = new DateTime( date("Y-m-d H:i:s"));
			$interval = $updated_at->diff($compare_time);
			if ($interval->h>6){
				$price->amount = $amount;
				$price->save();

			} 
			
		} else {
			$price = new Price(array('book_id' => $book->id, 'merchant_id' => $merchant->id, 'amount' => $amount, 'buy_url' => $buy_url, 'type' => $type));
			$price = $book->prices()->save($price);

		}
		
		return $price;
		
	}

	public static function getPrices($book){
    $isbn = $book->isbn13;
		$amazonXML = amazonXML($isbn);
		$amazonXML->registerXpathNamespace("xmlns", "http://webservices.amazon.com/AWSECommerceService/2011-08-01"); 
		$biggerbooksXML = simplexml_load_string(file_get_contents("http://www.biggerbooks.com/botpricexml?isbn=$isbn"));
		$valorebooksXML = simplexml_load_string(file_get_contents("http://prices.valorebooks.com/lookup-multiple-categories?SiteID=s1pI8Z&ProductCode=$isbn"));
		$ecampusXML = simplexml_load_string(file_get_contents("http://www.ecampus.com/botpricexml.asp?isbn=$isbn"));




		$merchants = Merchant::all();

		$merchant = array(); 
		foreach($merchants as $m){
			$merchant[$m->slug] = $m;
			}


		$amazonPrices = array(
      'new' => array(
      										'price' =>number_format((xmlParse('//xmlns:OfferSummary/xmlns:LowestNewPrice/xmlns:Amount', $amazonXML) / 100), 2), 
      										'url' => xmlParse('//xmlns:Item/xmlns:DetailPageURL', $amazonXML)
										),
      'used'=> array(
      										'price' =>number_format((xmlParse('//xmlns:OfferSummary/xmlns:LowestUsedPrice/xmlns:Amount', $amazonXML) / 100), 2), 
      										'url' => xmlParse('//xmlns:Offers/xmlns:MoreOffersUrl', $amazonXML)
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
	      									'price' =>number_format((xmlParse('//xmlns:TradeInValue/xmlns:Amount', $amazonXML) / 100), 2),
      										'url' =>xmlParse('//xmlns:Item/xmlns:DetailPageURL', $amazonXML)
      							) 
      	);

 		self::newPrice($book, $merchant['amazon'], 'new', $amazonPrices['new']['url'], $amazonPrices['new']['price']);
		self::newPrice($book, $merchant['amazon'], 'used', $amazonPrices['used']['url'], $amazonPrices['used']['price']);
		self::newPrice($book, $merchant['amazon'], 'buyback', $amazonPrices['buyback']['url'], $amazonPrices['buyback']['price']);
		//return $ecampusXML;

  //  $book = Book::find_or_create($isbn);
    
  //  return $book;
			$prices = Price::where('book_id','=',$book->id)->orderBy('amount', 'asc')->get();
			return $prices;
  }

}
