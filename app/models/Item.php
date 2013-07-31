<?php
class Item extends Eloquent {

	protected $table = 'items';
	protected $fillable = array('book_id', 'qty', 'price');

	public function order(){
		return $this->belongsTo('Order');
	}

	public function book(){
		return $this->hasOne('Book');
	}
}