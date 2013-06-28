<?php 
class Merchant extends Eloquent {

	protected $table = 'merchants';
	protected $fillable = array('aff_code', 'aff_login_url', 'description', 'logo_url', 'name', 'slug');

	public function prices(){
		$this->hasMany('Price');
	}
}