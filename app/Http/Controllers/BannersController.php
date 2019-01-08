<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Banner;
use Image;

class BannersController extends Controller
{
    public function addBanner() {
    	if ( request()->isMethod('post') ) {
    		$data = request()->except('_token');
    		$image_tmp = $data['banner_image'];
    		$banner = new Banner;
    		$banner->title = $data['title'];
    		$banner->link = $data['link'];
    		if (! isset($data['status'])) {
    			$data['status'] = 0;
    		}
    		$banner->status = $data['status'];
    		// Image
			if ($image_tmp->isValid()) {
				$ext         = $image_tmp->getClientOriginalExtension();
				$filename    = rand(1, 99999).'.'.$ext;
				$banner_path = 'images/frontend_images/banners/'.$filename;
				// Resize Image
				Image::make($image_tmp)->resize(1140, 340)->save($banner_path);
				$banner->image = $filename;
			}

			$banner->save();
			return redirect()->back()->withSuccessMessage('Banner Is Added Successfully.');
    	}

    	return view('admin.banners.add_banner');
    }

    public function viewBanners() {
    	$banners = Banner::get();
    	return view('admin.banners.view_banners', compact('banners'));
    }

    public function editBanner( $id = null ) {
    	if (request()->isMethod('post')) {

    		$data = request()->except('_token');
    		$banner = Banner::findOrFail($id);

    		if ( isset($data['image']) ) {
    			$image_tmp = $data['image'];
    			$currentBannerImg = $banner->image;
    			$currentBannerImgPath = 'images/frontend_images/banners/'.$currentBannerImg;
    			unlink($currentBannerImgPath);

				if ($image_tmp->isValid()) {
					$ext         = $image_tmp->getClientOriginalExtension();
					$filename    = rand(1, 99999).'.'.$ext;
					$banner_path = 'images/frontend_images/banners/'.$filename;
					// Resize Image
					Image::make($image_tmp)->resize(1140, 340)->save($banner_path);
					$banner->image = $filename;
				}
    		}

    		$banner->title = $data['title'];
    		$banner->link = $data['link'];
    		if (! isset($data['status'])) {
    			$data['status'] = 0;
    		}
    		$banner->status = $data['status'];
    		$banner->update();
    		return redirect()->back()->withSuccessMessage('Banner Updated Successfully.');
    	}

    	$banner = Banner::findOrFail($id);
    	return view('admin.banners.edit_banner', compact('banner'));
    }

    public function deleteBanner( $id = null ) {
    	if (request()->isMethod('post')) {
    		$banner = Banner::findOrFail($id);
			$bannerImg = $banner->image;
			$bannerImgPath = 'images/frontend_images/banners/'.$bannerImg;
			unlink($bannerImgPath);
			$banner->delete();
    		return redirect()->route('admin.show-banners')->withSuccessMessage('Banner has been deleted Successfully.');
    	}

    	$banner = Banner::findOrFail($id);
    	return view('admin.banners.delete_banner', compact('banner'));
    }
}
