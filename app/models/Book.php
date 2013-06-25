<?php
require_once('aws_signed_request.php');
require_once('simple_html_dom.php');

class Book extends Eloquent {
	private $isbn;
	protected $table = 'books';
	protected $fillable = array('title', 'author', 'publisher', 'image_url', 'isbn10', 'isbn13', 'amazon_url', 'edition', 'num_of_pages', 'list_price');


	public static function find_or_create($isbn){
		$amazon = self::amazonXML($isbn);
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

public static function amazonXML($isbn){
		$public_key = "AKIAI6SCW67W5JGC6KHQ";
		$private_key = "ZsS5CQfdoNgMrV/PLlE/aS7c/ff/EimPoI6yj7ir";
		$region = "com";

		$params = array(
											'Operation'=>"ItemLookup",
											'IdType'=>"ISBN",
											'Service'=>"AWSECommerceService",
											'AWSAccessKeyId'=>$public_key,
											'AssociateTag'=>"recycleabook-20",
	 										'Version'=>"2006-09-11",
	 										'Availability'=>"Available",
	 										'SearchIndex' => "All",
	 										'Condition'=>"All",
	 										'ItemPage'=>"1",
	 										'ResponseGroup'=>"ItemAttributes,Images,OfferFull,Offers",
	 										'ItemId'=> $isbn);
	$amazon_url = aws_signed_request($region, $params, $public_key, $private_key, $associate_tag=NULL, $version='2011-08-01');
	$amazonXML = simplexml_load_string(file_get_contents($amazon_url));

	return $amazonXML;
	}

	protected static function amazonParse($xpath, $xml){
			$bookmeta = $xml->xpath($xpath);
			$bookmeta = $bookmeta[0];
			return $bookmeta;
	}

private static function ordinalize($int){ 
			if(is_int($int)){
				if(in_array(($int % 100),range(11,13))){ 
					return $int . "th"; } 
				else { 
					switch(($int % 10)){ 
						case 1: 
							return $int . "st"; 
							break; 
						case 2: 
							return $int . "nd"; 
							break; 
						case 3: 
							return $int . "rd"; 
							break; 
						default: 
							return $int . "th"; 
							break; 
					}
		  	} 
			} else {
				return $int;
			}
		} 


	protected static function getBookData($isbn, $xml){
		//$xml = amazonXML($isbn);
		$xml->registerXpathNamespace("xmlns", "http://webservices.amazon.com/AWSECommerceService/2011-08-01"); 
		$edition = self::amazonParse('//xmlns:ItemAttributes/xmlns:Edition', $xml);
		$bookdata = array(
					"isbn10" => self::amazonParse('//xmlns:Items/xmlns:Item/xmlns:ASIN', $xml),
					"isbn13" => self::amazonParse('//xmlns:ItemAttributes/xmlns:EAN', $xml),
					"title" => self::amazonParse('//xmlns:ItemAttributes/xmlns:Title', $xml),
					"author" => self::amazonParse('//xmlns:ItemAttributes/xmlns:Author', $xml),
					"publisher" => self::amazonParse('//xmlns:ItemAttributes/xmlns:Publisher', $xml),
					"edition" => self::ordinalize($edition),
					"amazon_url" => self::amazonParse('//xmlns:DetailPageURL', $xml),
					"image_url" => self::amazonParse('//xmlns:LargeImage/xmlns:URL', $xml),
					"list_price" => self::amazonParse('//xmlns:ItemAttributes/xmlns:ListPrice/xmlns:Amount', $xml),
					"num_of_pages" => self::amazonParse('//xmlns:NumberOfPages', $xml)
					);
		return $bookdata;
	}

}
			