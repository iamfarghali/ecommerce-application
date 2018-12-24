<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Products;
use App\Category;

class IndexController extends Controller
{
    public function index() {
    	$products = Products::where('status', 1)->inRandomOrder()->get();
    	$categories = Category::with('subCategories')->get();
    	// dd($categories);
    	return view('index', compact('products', 'categories'));
    }
}
