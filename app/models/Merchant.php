<?php
class Merchant extends Eloquent {

	protected $table = 'merchants';
	protected $fillable = array('aff_code', 'aff_login_url', 'description', 'logo_url', 'name', 'slug');

	public function prices(){
		return $this->hasMany('Price');
	}

	public function books(){
		return $this->belongsToMany('Book', 'prices');
	}

		public function features(){
		return $this->belongsToMany('Feature', 'feature_merchant');
	}
}