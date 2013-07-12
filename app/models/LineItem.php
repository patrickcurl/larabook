<?php 
class LineItem extends Eloquent {

	protected $table = 'lineitems';
	protected $fillable = array('book_id', 'qty', 'price');

	public function order(){
		return $this->hasOne('Order');	
	}

	public function book(){
		return $this->hasOne('Book');
	}
}