<?php 
// require_once('aws_signed_request.php');
// require_once('simple_html_dom.php');
// require_once('functions.php');

class Price extends Eloquent {

	protected $table = 'prices';
	protected $fillable = array('book_id', 'merchant_id', 'amount', 'buy_url', 'condition', 'type');

  public function book(){
    return $this->belongsTo('Book');
  }

  public function merchant()
  {
    return $this->belongsTo('Merchant');
  }
}