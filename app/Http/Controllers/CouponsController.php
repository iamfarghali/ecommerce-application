<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Coupon;

class CouponsController extends Controller
{
    public function addCoupon() {
    	if ( request()->isMethod('post') ) {
    		$data = request()->all();
    		$coupon = new Coupon;
    		$coupon->coupon_code = $data['coupon_code'];
    		$coupon->amount_type = $data['amount_type'];
    		$coupon->expiry_date = $data['expiry_date'];
    		$coupon->amount 	 = $data['amount'];
    		if (! isset($data['status'])) {
    			$data['status'] = 0;
    		}
    		$coupon->status 	 = $data['status'];
    		$coupon->save();

	    	return redirect()->back()->withSuccessMessage('Coupon Is Added Successfully.');
    	}
    	return view('admin.coupons.add_coupon');
    }
}
