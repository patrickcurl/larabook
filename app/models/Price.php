<?php

class Price extends Eloquent {

	protected $table = 'prices';
	protected $fillable = array('book_id', 'merchant_id', 'amount_new', 'amount_used', 'amount_rental', 'amount_ebook', 'amount_buyback', 'url_new', 'url_used', 'url_rental', 'url_ebook', 'url_buyback');

  public function book(){
    return $this->belongsTo('Book');
  }

  public function merchant()
  {
    return $this->belongsTo('Merchant');
  }


  public static function getBest($prices){


    $best = array
      (
        'used'=>array
          (
            'price'=>null,
            'logo' => null
          ),
        'new'=>array
          (
            'price'=>null,
            'logo' => null
          ),
        'rental'=>array
          (
            'price'=>null,
            'logo' => null
          ),
        'ebook'=>array
          (
            'price'=>null,
            'logo' => null
          ),
        'buyback'=>array
          (
            'price'=>null,
            'logo' => null
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
      $best['used']['url'] = $price->url_used;
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
      $best['new']['url'] = $price->url_new;
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
      $best['rental']['url'] = $price->url_rental;
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
      $best['ebook']['url'] = $price->url_ebook;
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
      $best['buyback']['url'] = $price->url_buyback;
    }
  }
}
  //return $dumps;
  return $best;

}



}