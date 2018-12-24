<?php

namespace App\Http\Controllers;
use App\Category;

class CategoryController extends Controller {
	public function addCategory() {
		// dd(request()->all());
		if (request()->isMethod('post')) {
			$data                  = request()->all();
			$category              = new Category;
			$category->name        = $data['category_name'];
			$category->description = $data['description'];
			$category->parent_id   = $data['category_parent'];
			$category->url         = $data['url'];
			if (isset($data['status'])) {
				$category->status         = $data['status'];
			}
			$category->save();
			return redirect('admin/view-categories')->withSuccessMessage('Category Is Added Successfully.');
		}
		$levels = Category::where(['parent_id' => 0])->get();

		return view('admin.categories.add_category', compact('levels'));
	}

	public function viewCategories() {
		$categories = Category::get();
		return view('admin.categories.view_categories', compact('categories'));
	}

	public function showCategory($id) {
		$category    = Category::where(['id' => $id])->get()->first();
		$subCategory = null;
		if ($category->parent_id == 0) {
			$subCategory = Category::where(['parent_id' => $id])->get();
		}
		return view('admin.categories.show_category', compact('category', 'subCategory'));
	}

	public function editCategory($id = null) {
		if (request()->isMethod('post')) {
			$data = request()->all();
			if (isset($data['status']) == false) {
				$data['status'] = '0';
			}
			Category::where(['id' => $id])->update([
					'name'              => $data['category_name'],
					'parent_id'         => $data['category_parent'],
					'description'       => $data['description'],
					'url'               => $data['url'],
					'status'            => $data['status'],
				]);
			return redirect('admin/view-categories')->withSuccessMessage('Category Is Updated Successfully.');
		}
		$currentCategoryData = Category::where(['id'        => $id])->first();
		$levels              = Category::where(['parent_id' => 0])->get();
		return view('admin.categories.edit_category', compact('currentCategoryData', 'levels'));
	}

	public function deleteCategory($id = null) {
		if (request()->isMethod('post')) {
			Category::where(['id' => $id])->delete();
			return redirect('admin/view-categories')->withSuccessMessage('Category Is Deleted Successfully.');
		}
		$currentCategoryData = Category::where(['id' => $id])->first();
		return view('admin.categories.delete_category', compact('currentCategoryData'));
	}
}
