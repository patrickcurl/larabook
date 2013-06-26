<?php 
require_once('aws_signed_request.php');
require_once('simple_html_dom.php');
require_once('amazon_api.php');
class Price extends Eloquent {

	protected $table = 'prices';
	protected $fillable = array('book_id', 'merchant_id', 'amount', 'buy_url', 'condition', 'type');

	public static function getPrices($isbn){
		$amazonXML = amazonXML($isbn);
		$amazonXML->registerXpathNamespace("xmlns", "http://webservices.amazon.com/AWSECommerceService/2011-08-01"); 
		$biggerbooksXML = simplexml_load_string(file_get_contents("http://www.biggerbooks.com/botpricexml?isbn=$isbn"));
		$valorebooksXML = simplexml_load_string(file_get_contents("http://prices.valorebooks.com/lookup-multiple-categories?SiteID=s1pI8Z&ProductCode=$isbn"));
		$ecampusXML = simplexml_load_string(file_get_contents("http://www.ecampus.com/botpricexml.asp?isbn=$isbn"));


		//return $ecampusXML;


		$merchant_objects = DB::table('merchants')->get();

		$merchants = array();
		foreach($merchant_objects as $merchant_obj){
			//$merchant = DB::table('merchants')->where('slug', '=', $merchant_slug)->first();
			$merchant_values = array('slug' => $merchant_obj->slug, 'id' => $merchant_obj->id, 'image'=> $merchant_obj->logo_url, 'description' => $merchant_obj->description);
			$merchants[$merchant_obj->slug] = $merchant_values; 

			// 
			//$$merchant = DB::table('merchants')->where('slug', '=', $merchant)->first();

		}



		$book_prices = array(
				'new' 		=> 
						array(
										'amazon' 			=> 
												array(
																"price" => "$" . number_format((xmlParse('//xmlns:OfferSummary/xmlns:LowestNewPrice/xmlns:Amount', $amazonXML) / 100), 2),
																"description" => $merchants['amazon']['description'],
																"logo_url" => $merchants['amazon']['image'],
																"url" => xmlParse('//xmlns:OfferSummary/xmlns:LowestNewPrice/xmlns:Amount', $amazonXML)
												), 
										'biggerbooks' =>
												array(
																"price" => $biggerbooksXML->NewPrice[0],
																"description" => $merchants['biggerbooks']['description'],
																"logo_url" => $merchants['biggerbooks']['image'],
																"url" => "http://www.jdoqocy.com/click-7171865-9467039?ISBN=" . $isbn
												),

												
										'ecampus' 		=> 
												array(
																"price" => $ecampusXML->NewPrice[0],
																"description" => $merchants['ecampus']['description'],
																"logo_url" => $merchants['ecampus']['image'],
																"url" => "http://www.tkqlhce.com/click-7171865-5029466?ISBN=" . $isbn
												),

										'valorebooks' => 
												array(
																"price" => $valorebooksXML->NewPrice[0],
																"description" => $merchants['valorebooks']['description'],
																"logo_url" => $merchants['valorebooks']['image'],
																"url" => $valorebooksXML->xpath('//sale-offer/link')
												),
											
									), 
				'used' 		=> array(
					
					), 
				'rental'	=> array(),
				'ebook'		=> array(),
				'buyback' => array(),


			);
/*
		// E.G. $book_prices[--condition--][--merchant--][--price--];
		$book_prices['new']['']['price']
		$book_prices['new']['']['description']
		$book_prices['new']['']['logo_url']
		$book_prices['new']['']['price']
		$book_prices['new']['']['url']

		$book_prices['new']['']['price']
		$book_prices['new']['']['description']
		$book_prices['new']['']['logo_url']
		$book_prices['new']['']['price']
		$book_prices['new']['']['url']

		$book_prices['amazon']['new']['price'] = xmlParse('//xmlns:OfferSummary/xmlns:LowestNewPrice/xmlns:Amount', $amazonXML);
		$book_prices['amazon']['new']['url'] = xmlParse('', $amazonXML);
		$book_prices['amazon']['new']
*/		/* $book_prices['amazon']['used']['price'] = xmlParse('', $amazonXML);
		$book_prices['amazon']['used']['url'] = xmlParse('', $amazonXML);
		$book_prices['amazon']['rental']['price'] = xmlParse('', $amazonXML);
		$book_prices['amazon']['rental']['url'] = xmlParse('', $amazonXML);
		$book_prices['amazon']['buyback'] = xmlParse('', $amazonXML);
		$book_prices['amazon']['buyback'] = xmlParse('', $amazonXML);
		
		$book_prices['biggerbooks']['new']['price'] = '';
		$book_prices['biggerbooks']['new']['url'] = '';
		$book_prices['biggerbooks']['used']['price'] = '';
		$book_prices['biggerbooks']['used']['url'] = '';
		$book_prices['biggerbooks']['ebook']['price'] = '';
		$book_prices['biggerbooks']['ebook']['url'] = '';

		$book_prices['ecampus']['new']['price'] = '';
		$book_prices['ecampus']['new']['url'] = '';
		$book_prices['ecampus']['used']['price'] = '';
		$book_prices['ecampus']['used']['url'] = '';
		$book_prices['ecampus']['ebook']['price'] = '';
		$book_prices['ecampus']['ebook']['url'] = '';

		$book_prices['valorebooks']['new']['price'] = '';
		$book_prices['valorebooks']['new']['url'] = '';
		$book_prices['valorebooks']['rental']['price'] = '';
		$book_prices['valorebooks']['rental']['url'] = '';
		$book_prices['valorebooks']['buyback']['price'] = '';
		$book_prices['valorebooks']['buyback']['url'] = '';
		*/

		
		//$valorebooks = self::valorebooksXML($isbn);
		//$ecampusXML = simplexml_load_string(file_get_contents("http://www.ecampus.com/botpricexml.asp?isbn=$isbn"));
		//$title = $biggerbooks->NewPrice[0];
		//	return $title;
		//$merchants = array("abebooks","amazon","biggerbooks","bn","bookbyte","bookrenter","bookstores","campusbookrentals","chegg","coursesmart","ebay","ecampus","half","knetbooks","textbooksrus","textbookx","valorebooks");
		//$amazon = DB::table('merchants')->where('slug', '=', $merchant_slug)->first();
	return $book_prices;
		//$amazon = DB::table('merchants')->();

/*		$book_prices = array(
			"amazon" => array("type" => "buy", 
																	array(  
																	"new" => array(
																			"price" => "",
																			"type" => "buy",
																			"book_id" => "",
																			"merchant_id" => "",
																			"buy_url" => ""


																					 ), 
																	"used" => array(
																			"price" => "",
 																			"type" => "buy",
																			"book_id" => "",
																			"merchant_id" => "",
																			"buy_url" => ""



																					 ), 
																	"rental" => array(
																			"price" => "",
																			"type" => "buy",
																			"book_id" => "",
																			"merchant_id" => "",
																			"buy_url" => ""


																					 ), 
																	"INTL" => array(


																					 ), 
																	"Ebook" => array(


																					 )
																	)
																			"price" => "",
																			"type" => "buy",
																			"book_id" => "",
																			"merchant_id" => "",
																			"buy_url" => ""

				)


			);

return $merchants; */

	}
/*
	
	
	protected static function valorebooksXML(){

	}
	*/
}


/*

class Price < ActiveRecord::Base
	require 'uri'
  require 'net/http'
  
  attr_accessible :book_id, :buy_url, :condition, :merchant_id, :amount


  belongs_to :merchant
  belongs_to :book



  def self.getPrices(isbn10, isbn13)
    isbn = isbn13
    amazonapi = Price.amazon_api(isbn)
    bbooksapi = Price.bbooks_api(isbn)
    valoreapi = Price.valore_api(isbn)
    ecampusapi = Price.ecampus_api(isbn)
    images = {
      "amazon" => "http://www.campusbooks.com/images/markets/amazon.gif",
      "valore" => "http://www.campusbooks.com/images/markets/valoremarketplace.gif",
      "bbooks" => "http://www.campusbooks.com/images/markets/biggerbooks.gif",
      "ecampus" => "http://www.campusbooks.com/images/markets/ecampus_marketplace.gif"
    }
  	  

    ##Prices
    bbooks_new = bbooksapi.match(/<br>New Price: \$(.+?)<br>/)
    bbooks_new = bbooks_new[1] unless bbooks_new.nil?
    ecampus_new = ecampusapi.match(/<br>New Price: \$(.+?)<br>/)
    ecampus_new = ecampus_new[1] unless ecampus_new.nil?
    bbooks_used = bbooksapi.match(/<br>Used Price: \$(.+?)<br>/)
    bbooks_used = bbooks_used[1] unless bbooks_used.nil?
    ecampus_used = ecampusapi.match(/<br>Used Price: \$(.+?)<br>/)
    ecampus_used = ecampus_used[1] unless ecampus_used.nil?
    bbooks_ebook = bbooksapi.match(/<br>eBook Price: \$(.+?)<br>/)
    bbooks_ebook = bbooks_ebook[1] unless bbooks_ebook.nil?
    ecampus_ebook = ecampusapi.match(/<br>eBook Price: \$(.+?)<br>/)
    ecampus_ebook = ecampus_ebook[1] unless ecampus_ebook.nil?

myprices = {

      "amazonNew" => {
        "image" => images["amazon"],
        "price" => amazonapi.search('//xmlns:OfferSummary/xmlns:LowestNewPrice/xmlns:Amount').text.to_f / 100,
        "url" => amazonapi.search('//xmlns:DetailPageURL').text,
        "type" => "New"

      },
      "amazonUsed" => {
        "image" => images["amazon"],
        "price" => amazonapi.search('//xmlns:OfferSummary/xmlns:LowestUsedPrice/xmlns:Amount').text.to_f / 100,
        "url" => amazonapi.search('//xmlns:Offers/xmlns:MoreOffersUrl').text,
        "type" => "Used"
        
      },
            
      "amazonTrade" => {
        "image" => images["amazon"],
        "price" => amazonapi.search('//xmlns:TradeInValue/xmlns:Amount').text.to_f / 100,
        "url" => amazonapi.search('//xmlns:Item/xmlns:DetailPageURL').text,
        "type" => "BuyBack"
        
      },
      
      "valoreRental" =>
        {
          "image" => images["valore"],
          "price" => valoreapi.search('//rental-offer/semester-price').text,
          "url" => valoreapi.search('//rental-offer/link').text,
        "type" => "Rental"
          
        },
      
      "valoreNew" => {
        "image" => images["valore"],
        "price" => valoreapi.search('//sale-offer/price').text,
        "url" => valoreapi.search('//sale-offer/link').text,
        "type" => "New"
        
      },

      "valoreBuyBack" => {
        "image" => images["valore"],
        "price" => valoreapi.search('//buy-offer/item-price').text,
        "url" => "http://www.valorebooks.com/SellBack.AddItem_AddItem.do?query=" + isbn + "&site_id=s1pI8Z",
        "type" => "Buyback"
      },

      "bBooksNew" => {
          "image" => images["bbooks"],
          "price" => bbooks_new,
          "url" => "http://www.jdoqocy.com/click-7171865-9467039?ISBN=" + isbn,
          "type" => "New"
      },
      "bBooksUsed" => {
          "image" => images["bbooks"],
          "price" => bbooks_used,
          "url" => "http://www.jdoqocy.com/click-7171865-9467039?ISBN=" + isbn,
          "type" => "Used"
      },
      "bBooksEbook" => {
          "image" => images["bbooks"],
          "price" => bbooks_ebook,
          "url" => "http://www.jdoqocy.com/click-7171865-9467039?ISBN=" + isbn,
          "type" => "Ebook"
      },

      "eCampusNew" => {
          "image" => images["ecampus"],
          "price" => ecampus_new,
          "url" => "http://www.tkqlhce.com/click-7171865-5029466?ISBN=" + isbn,
          "type" => "New"
      },
      "eCampusUsed" => {
          "image" => images["ecampus"],
          "price" => ecampus_used,
          "url" => "http://www.tkqlhce.com/click-7171865-5029466?ISBN=" + isbn,
          "type" => "Used"
      },
      "eCampusEbook" => {
          "image" => images["ecampus"],
          "price" => ecampus_ebook,
          "url" => "http://www.tkqlhce.com/click-7171865-5029466?ISBN=" + isbn,
          "type" => "Ebook"
      }

   }


  end






def self.amazon_api(isbn)
		req = Vacuum.new 
		req.configure(YAML.load_file('config/amazon.yml'))

		parameters = { 
 		  'Operation'   => 'ItemLookup',
     	'SearchIndex' => 'All',
    	'IdType' => 'ISBN',
      'ResponseGroup' => 'ItemAttributes,Images,OfferFull,Offers',
      'ItemId'    => isbn
    }
   	@res = req.get(query: parameters)
   	Nokogiri::XML(@res.body)
	end

	def self.valore_api(isbn)
		response = Net::HTTP.get_response(URI.parse('http://prices.valorebooks.com/lookup-multiple-categories?SiteID=s1pI8Z&ProductCode=' + isbn)).body
		Nokogiri::XML(response)
	end

  def self.bb101_api(isbn)
    akey = "818cb7c79e9dec8b3d15c5e215b1e2193701af4b"
    affcode = "1532"
    url = "http://www.buyback101.com/bb101api.php?a=" + affcode + "&akey=" + akey + "&isbn=" + isbn + "&view=price"

    response = Net::HTTP.get_response(URI.parse(url)).body
    Nokogiri::XML(response)
  end

  def self.bbooks_api(isbn)
    # url = "http://www.jdoqocy.com/click-7171865-9467039?ISBN=" + isbn
    url = "http://www.biggerbooks.com/botprice?isbn=" + isbn
    response = Net::HTTP.get_response(URI.parse(url)).body
    # Nokogiri::HTML(response).search('//body/text')
  end

  def self.ecampus_api(isbn)
    # url = "http://www.jdoqocy.com/click-7171865-9467039?ISBN=" + isbn
    url = "http://www.ecampus.com/botprice.asp?isbn=" + isbn
    response = Net::HTTP.get_response(URI.parse(url)).body
    # Nokogiri::HTML(response).search('//body/text')
  end

def self.valore_price(isbn)

   response = Net::HTTP.get_response(URI.parse('http://prices.valorebooks.com/lookup-multiple-categories?SiteID=s1pI8Z&ProductCode=' + isbn)).body
  # doc = Nokogiri::XML(response)
  # doc.search('//product-code')
  # doc = Nokogiri::XML(res)
  # data = doc.search('//product-code')
  # puts data
end 
  def self.amazon_price(book)
  	@isbn = book.isbn10
  	#@book_id = book_id
  	# req = Vacuum.new 
		# req.configure(YAML.load_file('config/amazon.yml'))

		# parameters = { 
 		#  'Operation'   => 'ItemLookup',
    # 	'SearchIndex' => 'All',
    # 	'IdType' => 'ISBN',
    #  'ResponseGroup' => 'ItemAttributes,Images,OfferFull,Offers',
    #  'ItemId'    => @isbn
    # }
   	# @res = req.get(query: parameters)
   	# @doc = Nokogiri::XML(@res.body)
   	@doc = amazonApi(@isbn)
   	@newPrice = @doc.search('//xmlns:OfferSummary/xmlns:LowestNewPrice/xmlns:Amount').text.to_f / 100
   	@newUrl = @doc.search('//xmlns:DetailPageURL').text
   	
   	@usedPrice = @doc.search('//xmlns:OfferSummary/xmlns:LowestUsedPrice/xmlns:Amount').text.to_f / 100
   	@usedUrl = @doc.search('//xmlns:Offers/xmlns:MoreOffersUrl').text

   	@tradePrice = @doc.search('//xmlns:TradeInValue/xmlns:Amount').text.to_f / 100
   	@tradeUrl = @doc.search('//xmlns:Item/xmlns:DetailPageURL').text
   	puts @newPrice.to_s + " " + @newUrl
   	puts @usedPrice
   	puts @usedUrl
   	puts @tradePrice
   	puts @tradeUrl
   	puts @isbn
   	puts book.id


   	# Price.create(
   	#							book_id: @book_id,
   	#							buy_url: @newUrl,
   	#							condition: "New",
   	#							merchant_id: 1,
    #							amount: @newPrice
   	#						)

  end

  def self.testAmazon(isbn)
  	@isbn = isbn
  	puts amazonApi(isbn)

  end
  def self.test_method(test, name)
  	output = test
  	output2 = name
  end
end
*/