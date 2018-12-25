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

    public function editCoupon( $id = null ) {
        if (request()->isMethod('post')) {
            $data = request()->except('_token');
            $coupon = Coupon::findOrFail($data['couponID']);
            $coupon->coupon_code = $data['coupon_code'];
            $coupon->amount      = $data['amount'];
            $coupon->amount_type = $data['amount_type'];
            $coupon->expiry_date = $data['expiry_date'];
            if (! isset($data['status'])) {
                $data['status'] = 0;
            }
            $coupon->status      = $data['status'];
            $coupon->update();
            return redirect('admin/view-coupons')->withSuccessMessage('Coupon Is Updated');
        }
        $coupon = Coupon::findOrFail($id);
        return view('admin.coupons.edit_coupon', compact('coupon'));
    }

    public function viewCoupons() {
        $coupons = Coupon::get();
        return view('admin.coupons.view_coupons', compact('coupons'));
    }
}
