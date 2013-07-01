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
}