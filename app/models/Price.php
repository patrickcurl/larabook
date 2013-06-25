<?php 
require_once('aws_signed_request.php');
require_once('simple_html_dom.php');
require_once('amazon_api.php');
class Price extends Eloquent {

	protected $table = 'prices';
	protected $fillable = array('book_id', 'merchant_id', 'amount', 'buy_url', 'condition');

	public static function getPrices($isbn){
		$amazon = amazonXML($isbn);
		$biggerbooks = simplexml_load_string(file_get_contents("http://www.biggerbooks.com/botpricexml?isbn=$isbn"));
		//$valorebooks = self::valorebooksXML($isbn);
		$ecampus = simplexml_load_string(file_get_contents("http://www.ecampus.com/botpricexml.asp?isbn=$isbn"));
		$title = $biggerbooks->NewPrice[0];
			return $title;
	}
/*
	
	
	protected static function valorebooksXML(){

	}
	*/
}