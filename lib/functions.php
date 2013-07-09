<?php



function amazonXML($isbn){
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
	$amazonXML->registerXpathNamespace("xmlns", "http://webservices.amazon.com/AWSECommerceService/2011-08-01"); 
	return $amazonXML;
}

function amazonURL($isbn){
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
	// $amazonXML = simplexml_load_string(file_get_contents($amazon_url));
	// $amazonXML->registerXpathNamespace("xmlns", "http://webservices.amazon.com/AWSECommerceService/2011-08-01"); 
	return $amazon_url;

}

function xmlParse($xpath, $xml){
	if($xml){
			if($xpath){
				//$bookmeta = array();
				//$bookmeta[0] = "";
				$bookmeta = $xml->xpath($xpath);
				$bookmeta = $bookmeta[0];
				//if ($bookmeta[0]){
				//	print_r(var_dump($bookmeta));
				return $bookmeta;
			}
			
	} else {
		return 0;
	}

	
}

function ordinalize($int){ 
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

// Get Amazon Price Data

?>