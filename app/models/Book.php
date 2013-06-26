<?php
require_once('aws_signed_request.php');
require_once('simple_html_dom.php');
require_once('amazon_api.php');
class Book extends Eloquent {
	private $isbn;
	protected $table = 'books';
	protected $fillable = array('title', 'author', 'publisher', 'image_url', 'isbn10', 'isbn13', 'amazon_url', 'edition', 'num_of_pages', 'list_price');


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

}
			