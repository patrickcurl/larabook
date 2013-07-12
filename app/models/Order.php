<?php 
class Order extends Eloquent {

	protected $table = 'orders';
	protected $fillable = array('user_id', 'tracking_number', 'total_amount', 'shipment_received', 'payment_sent', 'comments');

	public function lineItems(){
		return $this->hasMany('LineItem');	
	}

	public function user(){
		return $this->hasOne('User');
	}
}