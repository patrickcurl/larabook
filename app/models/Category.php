<?php
class Category extends Eloquent {

  protected $table = 'categories';
  protected $fillable = array('name', 'description');


}