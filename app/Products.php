<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model {
	protected $guarded = [
		'id', 'created_at', 'updated_at'
	];

	// Get Attributes for product
	public function attributes() {
		return $this->hasMany('App\ProductsAttribute', 'product_id');
	}
}
