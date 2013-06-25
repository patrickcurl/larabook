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

	return $amazonXML;
}

?>