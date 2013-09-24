<?php

class Feature extends Eloquent {
	protected $guarded = array();
	protected $fillable = array('name', 'description', 'icon_url');
	public static $rules = array();

	public function merchants(){
		return $this->belongsToMany('Merchant', 'feature_merchant');
	}
}