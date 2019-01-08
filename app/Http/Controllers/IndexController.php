<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Products;
use App\Category;
use App\Banner;

class IndexController extends Controller
{
    public function index() {
    	$products = Products::where('status', 1)->inRandomOrder()->get();
    	$categories = Category::with('subCategories')->get();
    	$banners = Banner::get();
    	return view('index', compact('products', 'categories', 'banners'));
    }
}
