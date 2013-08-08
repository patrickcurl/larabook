<?php



function amazonXML($isbn){
		$region = "com";
		$params = array(
											'Operation'=>"ItemLookup",
											'IdType'=>"ISBN",
											'Service'=>"AWSECommerceService",
											'AWSAccessKeyId'=>Config::get('env_vars.amazon_public_key'),
											'AssociateTag'=>Config::get('env_vars.amazon_ass_tag'),
	 										'Version'=>"2006-09-11",
	 										'Availability'=>"Available",
	 										'SearchIndex' => "All",
	 										'Condition'=>"All",
	 										'ItemPage'=>"1",
	 										'ResponseGroup'=>"ItemAttributes,Images,OfferFull,Offers,Reviews,EditorialReview,BrowseNodes,SalesRank",
	 										//'ResponseGroup' =>"Large",
	 										'ItemId'=> $isbn);
	$amazon_url = aws_signed_request($region, $params, Config::get('env_vars.amazon_public_key'), Config::get('env_vars.amazon_private_key'), $associate_tag=NULL, $version='2011-08-01');
	$amazonXML = simplexml_load_string(file_get_contents($amazon_url));
	$amazonXML->registerXpathNamespace("xmlns", "http://webservices.amazon.com/AWSECommerceService/2011-08-01");
	return $amazonXML;
}

function amazonDOM($isbn){
		$region = "com";
		$params = array(
											'Operation'=>"ItemLookup",
											'IdType'=>"ISBN",
											'Service'=>"AWSECommerceService",
											'AWSAccessKeyId'=>Config::get('env_vars.amazon_public_key'),
											'AssociateTag'=>Config::get('env_vars.amazon_ass_tag'),
	 										'Version'=>"2006-09-11",
	 										'Availability'=>"Available",
	 										'SearchIndex' => "All",
	 										'Condition'=>"All",
	 										'ItemPage'=>"1",
	 										'ResponseGroup'=>"ItemAttributes,Images,OfferFull,Offers,Reviews,EditorialReview,BrowseNodes,SalesRank",
	 										//'ResponseGroup' =>"Large",
	 										'ItemId'=> $isbn);
	$amazon_url = aws_signed_request($region, $params, Config::get('env_vars.amazon_public_key'), Config::get('env_vars.amazon_private_key'), $associate_tag=NULL, $version='2011-08-01');
	// $amazonXML = simplexml_load_string(file_get_contents($amazon_url));
	// $amazonXML->registerXpathNamespace("xmlns", "http://webservices.amazon.com/AWSECommerceService/2011-08-01");
	$doc = new DOMDocument();
	$doc->load($amazon_url);
	$doc->preserveWhiteSpace = false;
  $doc->formatOutput = true;
	$xpath = new DOMXPath($doc);
	$xpath->registerNamespace("xmlns", "http://webservices.amazon.com/AWSECommerceService/2011-08-01");
	$query = '//xmlns:BrowseNode/xmlns:Name';
	$entries = $xpath->query($query);
	return $entries;
}

function amazonURL($isbn){
		$region = "com";

		$params = array(
											'Operation'=>"ItemLookup",
											'IdType'=>"ISBN",
											'Service'=>"AWSECommerceService",
											'AWSAccessKeyId'=>Config::get('env_vars.amazon_public_key'),
											'AssociateTag'=>Config::get('env_vars.amazon_ass_tag'),
	 										'Version'=>"2006-09-11",
	 										'Availability'=>"Available",
	 										'SearchIndex' => "All",
	 										'Condition'=>"All",
	 										'ItemPage'=>"1",
	 										'ResponseGroup'=>"ItemAttributes,Images,OfferFull,Offers,Reviews,EditorialReview,BrowseNodes,SalesRank",
	 										'ItemId'=> $isbn);
	$amazon_url = aws_signed_request($region, $params, Config::get('env_vars.amazon_public_key'), Config::get('env_vars.amazon_private_key'), $associate_tag=NULL, $version='2011-08-01');

	return $amazon_url;

}

function xmlParse($xpath, $xml){
	if($xml){
			if($xpath){
				$bookmeta = $xml->xpath($xpath);
				$bookmeta = $bookmeta[0];
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



// Get UPS Shipping Label
		function getLabel($customer, $weight){
	$license = Config::get('env_vars.ups_license');
	$user = Config::get('env_vars.ups_user');
	$pass = Config::get('env_vars.ups_pass');
	$company = Config::get('env_vars.ups_company');

	$ups_confirm_url = "https://wwwcie.ups.com/ups.app/xml/ShipConfirm";
	$ups_accept_url = "https://wwwcie.ups.com/ups.app/xml/ShipAccept";

	$ups_confirm_request = "
				<?xml version='1.0'?>
				<AccessRequest xml:lang='en-US'>
				  <AccessLicenseNumber>$license</AccessLicenseNumber>
				  <UserId>$user</UserId>
				  <Password>$pass</Password>
				</AccessRequest>
				<?xml version='1.0'?>
				<ShipmentConfirmRequest xml:lang='en-US'>
				  <Request>
				    <TransactionReference>
				      <CustomerContext>Customer Comment</CustomerContext>
				      <XpciVersion/>
				    </TransactionReference>
				    <RequestAction>ShipConfirm</RequestAction>
				    <RequestOption>validate</RequestOption>
				  </Request>
				  <LabelSpecification>
				    <LabelPrintMethod>
				      <Code>GIF</Code>
				      <Description>gif file</Description>
				    </LabelPrintMethod>
				    <HTTPUserAgent>Mozilla/4.5</HTTPUserAgent>
				    <LabelImageFormat>
				      <Code>GIF</Code>
				      <Description>gif</Description>
				    </LabelImageFormat>
				  </LabelSpecification>
				  <Shipment>
				   <RateInformation>
				      <NegotiatedRatesIndicator/>
				    </RateInformation>
					<Description/>
				    <Shipper>
				      <Name>{$company['name']}</Name>
				      <PhoneNumber>{$company['phone']}</PhoneNumber>
				      <ShipperNumber>{$company['ship_num']}</ShipperNumber>
					  <TaxIdentificationNumber></TaxIdentificationNumber>
				      <Address>
				    	<AddressLine1>{$company['address']}</AddressLine1>
				    	<City>{$company['city']}</City>
				    	<StateProvinceCode>{$company['state']}</StateProvinceCode>
				    	<PostalCode>{$company['zip']}</PostalCode>
				    	<PostcodeExtendedLow></PostcodeExtendedLow>
				    	<CountryCode>US</CountryCode>
				     </Address>
				    </Shipper>
					<ShipTo>
				     <CompanyName>{$company['name']}</CompanyName>
				      <AttentionName>{$company['attn']}</AttentionName>
				      <PhoneNumber>{$company['phone']}</PhoneNumber>
				      <Address>
				        <AddressLine1>{$company['address']}</AddressLine1>
				        <City>{$company['city']}</City>
				        <StateProvinceCode>{$company['state']}</StateProvinceCode>
				        <PostalCode>{$company['zip']}</PostalCode>
				        <CountryCode>US</CountryCode>
				      </Address>
				    </ShipTo>
				    <ShipFrom>
				      <CompanyName>{$customer['first_name']} {$customer['last_name']}</CompanyName>
				      <AttentionName>{$customer['first_name']} {$customer['last_name']}</AttentionName>
				      <PhoneNumber>{$customer['phone']}</PhoneNumber>
					  <TaxIdentificationNumber></TaxIdentificationNumber>
				      <Address>
				        <AddressLine1>{$customer['address']}</AddressLine1>
				        <City>{$customer['city']}</City>
				    	<StateProvinceCode>{$customer['state']}</StateProvinceCode>
				    	<PostalCode>{$customer['zip']}</PostalCode>
				    	<CountryCode>US</CountryCode>
				      </Address>
				    </ShipFrom>
				     <PaymentInformation>
				      <Prepaid>
				        <BillShipper>
				          <AccountNumber>{$company['ship_num']}</AccountNumber>
				        </BillShipper>
				      </Prepaid>
				    </PaymentInformation>
				    <Service>
				      <Code>03</Code>
				      <Description>Ground</Description>
				    </Service>
				    <Package>
				      <PackagingType>
				        <Code>02</Code>
				        <Description>Customer Supplied</Description>
				      </PackagingType>
				      <Description>Package Description</Description>
					  <ReferenceNumber>
					  	<Code>00</Code>
						<Value>Package</Value>
					  </ReferenceNumber>
				      <PackageWeight>
				        <UnitOfMeasurement>
				        	<Code>LBS</Code>
				        </UnitOfMeasurement>
				        <Weight>$weight</Weight>
				      </PackageWeight>

				      <AdditionalHandling>0</AdditionalHandling>
				    </Package>
				  </Shipment>
				</ShipmentConfirmRequest>";

	// using Laravel Curl plugin for easier implementation of Curl
	$curl = new Curl;
	$curl->create($ups_confirm_url);
	$curl->option('ssl_verifypeer', 0);
	$curl->option('returntransfer', 1);
	$curl->option('header', 0);
	$curl->option('post', 1);
	$curl->option('postfields', $ups_confirm_request);
	$curl->option('timeout',3600);
	$ups_confirm_response = new SimpleXMLElement($curl->execute());
	// form the accept request in order to issue a label
	$ups_accept_request = "
	<?xml version='1.0' encoding='ISO-8859-1'?>
	  <AccessRequest>
	    <AccessLicenseNumber>$license</AccessLicenseNumber>
	    <UserId>$user</UserId>
	    <Password>$pass</Password>
	  </AccessRequest>
	<?xml version='1.0' encoding='ISO-8859-1'?>
	  <ShipmentAcceptRequest>
	    <Request>
	      <TransactionReference>
	        <CustomerContext>Customer Comment</CustomerContext>
	      </TransactionReference>
	      <RequestAction>ShipAccept</RequestAction>
	      <RequestOption>1</RequestOption>
	    </Request><ShipmentDigest>{$ups_confirm_response->ShipmentDigest}</ShipmentDigest>
	    </ShipmentAcceptRequest>";
	$curl = new Curl;
	$curl->create($ups_accept_url);
	$curl->option('ssl_verifypeer', 0);
	$curl->option('returntransfer', 1);
	$curl->option('header', 0);
	$curl->option('post', 1);
	$curl->option('postfields', $ups_accept_request);
	$curl->option('timeout',3600);
	$ups_accept_response =  new SimpleXMLElement($curl->execute());
	//return $ups_accept_response;
  $tracking_number = $ups_accept_response->ShipmentResults->PackageResults->TrackingNumber;
	$label = $ups_accept_response->ShipmentResults->PackageResults->LabelImage->GraphicImage;
  $data = array('tracking_number' => $tracking_number, 'label' => $label);
	return $data;
	//return $customer['address'];

}

function getHtmlLabel($customer, $weight){
	$license = Config::get('env_vars.ups_license');
	$user = Config::get('env_vars.ups_user');
	$pass = Config::get('env_vars.ups_pass');
	$company = Config::get('env_vars.ups_company');

	$ups_confirm_url = "https://wwwcie.ups.com/ups.app/xml/ShipConfirm";
	$ups_accept_url = "https://wwwcie.ups.com/ups.app/xml/ShipAccept";

	$ups_confirm_request = "
				<?xml version='1.0'?>
				<AccessRequest xml:lang='en-US'>
				  <AccessLicenseNumber>$license</AccessLicenseNumber>
				  <UserId>$user</UserId>
				  <Password>$pass</Password>
				</AccessRequest>
				<?xml version='1.0'?>
				<ShipmentConfirmRequest xml:lang='en-US'>
				  <Request>
				    <TransactionReference>
				      <CustomerContext>Customer Comment</CustomerContext>
				      <XpciVersion/>
				    </TransactionReference>
				    <RequestAction>ShipConfirm</RequestAction>
				    <RequestOption>validate</RequestOption>
				  </Request>
				  <LabelSpecification>
				    <LabelPrintMethod>
				      <Code>GIF</Code>
				      <Description>gif file</Description>
				    </LabelPrintMethod>
				    <HTTPUserAgent>Mozilla/4.5</HTTPUserAgent>
				    <LabelImageFormat>
				      <Code>GIF</Code>
				      <Description>gif</Description>
				    </LabelImageFormat>
				  </LabelSpecification>
				  <Shipment>
				   <RateInformation>
				      <NegotiatedRatesIndicator/>
				    </RateInformation>
					<Description/>
				    <Shipper>
				      <Name>{$company['name']}</Name>
				      <PhoneNumber>{$company['phone']}</PhoneNumber>
				      <ShipperNumber>{$company['ship_num']}</ShipperNumber>
					  <TaxIdentificationNumber></TaxIdentificationNumber>
				      <Address>
				    	<AddressLine1>{$company['address']}</AddressLine1>
				    	<City>{$company['city']}</City>
				    	<StateProvinceCode>{$company['state']}</StateProvinceCode>
				    	<PostalCode>{$company['zip']}</PostalCode>
				    	<PostcodeExtendedLow></PostcodeExtendedLow>
				    	<CountryCode>US</CountryCode>
				     </Address>
				    </Shipper>
					<ShipTo>
				     <CompanyName>{$company['name']}</CompanyName>
				      <AttentionName>{$company['attn']}</AttentionName>
				      <PhoneNumber>{$company['phone']}</PhoneNumber>
				      <Address>
				        <AddressLine1>{$company['address']}</AddressLine1>
				        <City>{$company['city']}</City>
				        <StateProvinceCode>{$company['state']}</StateProvinceCode>
				        <PostalCode>{$company['zip']}</PostalCode>
				        <CountryCode>US</CountryCode>
				      </Address>
				    </ShipTo>
				    <ShipFrom>
				      <CompanyName>{$customer['first_name']} {$customer['last_name']}</CompanyName>
				      <AttentionName>{$customer['first_name']} {$customer['last_name']}</AttentionName>
				      <PhoneNumber>{$customer['phone']}</PhoneNumber>
					  <TaxIdentificationNumber></TaxIdentificationNumber>
				      <Address>
				        <AddressLine1>{$customer['address']}</AddressLine1>
				        <City>{$customer['city']}</City>
				    	<StateProvinceCode>{$customer['state']}</StateProvinceCode>
				    	<PostalCode>{$customer['zip']}</PostalCode>
				    	<CountryCode>US</CountryCode>
				      </Address>
				    </ShipFrom>
				     <PaymentInformation>
				      <Prepaid>
				        <BillShipper>
				          <AccountNumber>{$company['ship_num']}</AccountNumber>
				        </BillShipper>
				      </Prepaid>
				    </PaymentInformation>
				    <Service>
				      <Code>03</Code>
				      <Description>Ground</Description>
				    </Service>
				    <Package>
				      <PackagingType>
				        <Code>02</Code>
				        <Description>Customer Supplied</Description>
				      </PackagingType>
				      <Description>Package Description</Description>
					  <ReferenceNumber>
					  	<Code>00</Code>
						<Value>Package</Value>
					  </ReferenceNumber>
				      <PackageWeight>
				        <UnitOfMeasurement>
				        	<Code>LBS</Code>
				        </UnitOfMeasurement>
				        <Weight>$weight</Weight>
				      </PackageWeight>

				      <AdditionalHandling>0</AdditionalHandling>
				    </Package>
				  </Shipment>
				</ShipmentConfirmRequest>";

	// using Laravel Curl plugin for easier implementation of Curl
	$curl = new Curl;
	$curl->create($ups_confirm_url);
	$curl->option('ssl_verifypeer', 0);
	$curl->option('returntransfer', 1);
	$curl->option('header', 0);
	$curl->option('post', 1);
	$curl->option('postfields', $ups_confirm_request);
	$curl->option('timeout',3600);
	$ups_confirm_response = new SimpleXMLElement($curl->execute());
	// form the accept request in order to issue a label
	$ups_accept_request = "
	<?xml version='1.0' encoding='ISO-8859-1'?>
	  <AccessRequest>
	    <AccessLicenseNumber>$license</AccessLicenseNumber>
	    <UserId>$user</UserId>
	    <Password>$pass</Password>
	  </AccessRequest>
	<?xml version='1.0' encoding='ISO-8859-1'?>
	  <ShipmentAcceptRequest>
	    <Request>
	      <TransactionReference>
	        <CustomerContext>Customer Comment</CustomerContext>
	      </TransactionReference>
	      <RequestAction>ShipAccept</RequestAction>
	      <RequestOption>1</RequestOption>
	    </Request><ShipmentDigest>{$ups_confirm_response->ShipmentDigest}</ShipmentDigest>
	    </ShipmentAcceptRequest>";
	$curl = new Curl;
	$curl->create($ups_accept_url);
	$curl->option('ssl_verifypeer', 0);
	$curl->option('returntransfer', 1);
	$curl->option('header', 0);
	$curl->option('post', 1);
	$curl->option('postfields', $ups_accept_request);
	$curl->option('timeout',3600);
	$ups_accept_response =  new SimpleXMLElement($curl->execute());
	// return $ups_accept_response;
	$data = $ups_accept_response->ShipmentResults->PackageResults->LabelImage->HTMLImage;
	return $data;
	//return $customer['address'];

}
?>