<?php









//$user = User::find(2);
//file_put_contents('test123.gif', base64_decode(getLabel($user, 2.5)));
//$filename = 'test123.gif';
//$source = imagecreatefromgif($filename);
//$label =  imagerotate($source, 90, 0);
//echo imagejpeg($label);
//$label = getLabel($user, 2.5);
//echo var_dump($label);


//echo '<img src="data:image/gif;base64,' . $label . '" height="392" and width="651"/>';
//var_dump($user);
//var_dump(getLabel($user));
//echo '<br /><img src="data:image/gif;base64,895UIGJ89XCASDVIGFUISDFNKLFSDANUI43UIT34IONSDFKHG89GUKGJNGKDJFKDJDGKJDKFSDU089REUTDRKJOEIOUTERIJREIKGRJIGOWEJIEJIEGJGRIOEJGRIGJIODJGFIODFJSIOUDFIOGDFUGDF890ERUTRIOGTJRDIOOGJGIOSDFJGIOJGIOJIOGFUGJIOGU90E8T9TRFIRWEU90WERU90WU90WTU90WUT09WEUTWRJGKSDFJGIOSDFJGOISDFJGIOSJSD" />';

/*
$a = amazonXML(1111837295);
$n = $a->xpath('//xmlns:BrowseNode/xmlns:Name');

foreach ($n as $b){
  echo $b;
}
*/
//$isbn = "1111111111";
//$response = Book::cache_xml($isbn, 'amazon', amazonURL($isbn));
//$response->registerXpathNamespace("xmlns", "http://webservices.amazon.com/AWSECommerceService/2011-08-01");
//$a_error = $response->xpath('//xmlns:Errors/xmlns:Error');
//echo var_dump(empty($a_error));
//$test = Book::getPowell('9780131367739');
//$test = Book::getPowell('9780140237207');
//var_dump($test);
//$price =Book::curlPrice("http://www.sellbackbooks.com/bbsearchresult.aspx?ISBN=978013136773", "<p class=\"price\"", "</p>", "p");
$prices = DB::table('prices')
                ->join('merchants', function($join){
                  $join->on('prices.merchant_id', '=', 'merchants.id');
                })->where('prices.book_id', '=', 1)->get();
  $best = array
      (
        'used'=>array
          (
            'price'=>array(),
            'logo' => array()
          ),
        'new'=>array
          (
            'price'=>array(),
            'logo' => array()
          ),
        'rental'=>array
          (
            'price'=>array(),
            'logo' => array()
          ),
        'ebook'=>array
          (
            'price'=>array(),
            'logo' => array()
          ),
        'buyback'=>array
          (
            'price'=>array(),
            'logo' => array()
          ),
      );
foreach ($prices as $price){
  if (!empty($price->amount_used)){
    // Does used price value exist? yes it does...
    if(empty($best['used']['price']) || ($best['used']['price'] > $price->amount_used)){
      // Is there a price to compare in array?
      // if not, then let's give it one.
      $best['used']['price'] = $price->amount_used;

      // attach the merchant to the array.
      $best['used']['logo'] = $price->logo_url;
    }
  }

  if (!empty($price->amount_new)){
    // Does new price value exist? yes it does...
    if(empty($best['new']['price']) || ($best['new']['price'] > $price->amount_new)){
      // Is there a price to compare in array?
      // if not, then let's give it one.
      $best['new']['price'] = $price->amount_new;

      // attach the merchant to the array.
      $best['new']['logo'] = $price->logo_url;
    }
  }

  if (!empty($price->amount_rental)){
    // Does rental price value exist? yes it does...
    if(empty($best['rental']['price']) || ($best['rental']['price'] > $price->amount_rental)){
      // Is there a price to compare in array?
      // if not, then let's give it one.
      $best['rental']['price'] = $price->amount_rental;

      // attach the merchant to the array.
      $best['rental']['logo'] = $price->logo_url;
    }
  }


  if (!empty($price->amount_ebook)){
    // Does ebook price value exist? yes it does...
    if(empty($best['ebook']['price']) || ($best['ebook']['price'] > $price->amount_ebook)){
      // Is there a price to compare in array?
      // if not, then let's give it one.
      $best['ebook']['price'] = $price->amount_ebook;

      // attach the merchant to the array.
      $best['ebook']['logo'] = $price->logo_url;
    }
  }

  if (!empty($price->amount_buyback)){
    // Does buyback price value exist? yes it does...
    if(empty($best['buyback']['price']) || ($best['buyback']['price'] < $price->amount_buyback)){
      // Is there a price to compare in array?
      // if not, then let's give it one.
      $best['buyback']['price'] = $price->amount_buyback;

      // attach the merchant to the array.
      $best['buyback']['logo'] = $price->logo_url;
    }

  }
}
$best = Price::getBest($prices);
var_dump($best);

                // ->join('merchants', 'merchants.id', '=', 'prices.merchants_id')
                // ->select('prices.amount_used', 'merchants.slug')
                // ->where('book_id', '=', 1 );

// $isbn = "0133084043";
// $book = Book::find_or_create($isbn);
// $prices = Book::getPrices($book);
// //$best = array('used' => null, 'new' => null, 'rental' => null, 'ebook' => null, 'buyback' => null)
// $best = array
//       (
//         'used'=>array
//           (
//             'price'=>array(),
//             'merchant' => array()
//           )
//       );
// foreach ($prices as $price){



//   if (!empty($price->amount_used)){
//     // Does used price value exist? yes it does...


//     if(empty($best['used']['price']) || ($best['used']['price'] > $price->amount_used)){
//       // Is there a price to compare in array?
//       // if not, then let's give it one.
//       $best['used']['price'] = $price->amount_used;

//       // attach the merchant to the array.
//       $best['used']['merchant'] = $price->merchant;
//     }
//   }

//   if (!empty($price->amount_new)){
//     // Does new price value exist? yes it does...
//     if(empty($best['new']['price']) || ($best['new']['price'] > $price->amount_new)){
//       // Is there a price to compare in array?
//       // if not, then let's give it one.
//       $best['new']['price'] = $price->amount_new;

//       // attach the merchant to the array.
//       $best['new']['merchant'] = $price->merchant;
//     }
//   }

//   if (!empty($price->amount_rental)){
//     // Does rental price value exist? yes it does...
//     if(empty($best['rental']['price']) || ($best['rental']['price'] > $price->amount_rental)){
//       // Is there a price to compare in array?
//       // if not, then let's give it one.
//       $best['rental']['price'] = $price->amount_rental;

//       // attach the merchant to the array.
//       $best['rental']['merchant'] = $price->merchant;
//     }
//   }


//   if (!empty($price->amount_ebook)){
//     // Does ebook price value exist? yes it does...
//     if(empty($best['ebook']['price']) || ($best['ebook']['price'] > $price->amount_ebook)){
//       // Is there a price to compare in array?
//       // if not, then let's give it one.
//       $best['ebook']['price'] = $price->amount_ebook;

//       // attach the merchant to the array.
//       $best['ebook']['merchant'] = $price->merchant;
//     }
//   }

//   if (!empty($price->amount_buyback)){
//     // Does buyback price value exist? yes it does...
//     if(empty($best['buyback']['price']) || ($best['buyback']['price'] < $price->amount_buyback)){
//       // Is there a price to compare in array?
//       // if not, then let's give it one.
//       $best['buyback']['price'] = $price->amount_buyback;

//       // attach the merchant to the array.
//       $best['buyback']['merchant'] = $price->merchant;
//     }

//   }
// }
// $besty = Price::getBest($prices);
// var_dump($besty['used']);



/*function getBestPrices($price){
  $best = array('used' => null, 'new' => null, 'rental' => null, 'ebook' => null, 'buyback' => null)
}
*
//$best_used = Price::getBest('used');
//var_dump($prices);
$book_id = $book->id;
//$best_used =  DB::table('prices')->where('book_id', '=',$book_id)->where('amount_used', '<>', 'NULL')->orderBy('amount_used')->first();

//var_dump($best_used);
// $charBegin = stripos($html, '<p class="price"');
// var_dump($charBegin);
/*if($charBegin){
  $htmlList = substr($html, $charBegin, strlen($html));
  $charLast = stripos($htmlList, '</p>');
  $htmlList=substr($htmlList, 0, $charLast+4);
}
*/


//var_dump($htmlList);
/*
$test = str_replace("<HTML><BODY><PRE>\n", "", $test);
$test = str_replace("\n\n</PRE>", "", $test);
$test = str_replace("Notes:\n", "", $test);
$test2 = explode("\n\n", strip_tags($test));

$test3 = array();

foreach($test2 as $key=>$value){
  $value = explode("\n", $value);
  foreach($value as $val){
    $parts = explode(": ", $val, 2);
    if (sizeof($parts > 1)){
     $test3[$key][$parts[0]] = $parts[1];
    }
  }
}
$bestNew = 0;
$bestUsed = 0;
foreach ($test3 as $t){
  if ($t['Class'] == "NEW"){
    if($bestNew == 0){
      $bestNew = $t['Price'];
    } else {
      if ($t['Price'] < $bestNew){
        $bestNew = $t['Price'];
      }
    }
  }
    if ($t['Class'] == "USED"){
      if($bestUsed == 0){
        $bestUsed = $t['Price'];
      } else {
        if ($t['Price'] < $bestUsed){
          $bestUsed = $t['Price'];
        }
      }
    }

}

var_dump($bestNew);

var_dump($bestUsed);
var_dump($test3);
*/

