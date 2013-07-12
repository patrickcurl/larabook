@extends('layouts.master')
@section('content')



	<?php 

// SHIP ACCEPT REQUEST
$xmlRequest1='<?xml version="1.0″ encoding="ISO-8859-1″?>
<AccessRequest>
<AccessLicenseNumber>7CB1086EA7F00776</AccessLicenseNumber>
<UserId>jodyrecycleabook</UserId>
<Password>04Lynne!</Password>
</AccessRequest>
<?xml version="1.0″ encoding="ISO-8859-1″?>
<ShipmentAcceptRequest>
<Request>
<TransactionReference>
<CustomerContext>Customer Comment</CustomerContext>
</TransactionReference>
<RequestAction>ShipAccept</RequestAction>
<RequestOption>1</RequestOption>
</Request>
<ShipmentDigest>SHIPMENT DIGEST</ShipmentDigest>
</ShipmentAcceptRequest>
';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://wwwcie.ups.com/ups.app/xml/ShipAccept&#8221");
// uncomment the next line if you get curl error 60: error setting certificate verify locations
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
// uncommenting the next line is most likely not necessary in case of error 60
// curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlRequest1);
curl_setopt($ch, CURLOPT_TIMEOUT, 3600);

//if ($this->logfile) {
//   error_log("UPS REQUEST: " . $xmlRequest . "\n", 3, $this->logfile);
//}
$xmlResponse = curl_exec ($ch); // SHIP ACCEPT RESPONSE
//echo curl_errno($ch);

$xml = $xmlResponse;

preg_match_all( "/\<ShipmentAcceptResponse\>(.*?)\<\/ShipmentAcceptResponse\>/s",
$xml, $bookblocks );

foreach( $bookblocks[1] as $block )
{
preg_match_all( "/\<GraphicImage\>(.*?)\<\/GraphicImage\>/",
$block, $author ); // GET LABEL

preg_match_all( "/\<TrackingNumber\>(.*?)\<\/TrackingNumber\>/",
$block, $tracking ); // GET TRACKING NUMBER
//echo( $author[1][0]."\n" );
}

echo '<img src="data:image/gif;base64,'. $author[1][0]. '"/>';


	?>
@stop