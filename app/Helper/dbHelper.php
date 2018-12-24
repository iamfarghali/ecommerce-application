<?php

use App\Category;

if (!function_exists('getParentCategoryName')) {

function getParentCategoryName($parent_id) {
		if ($parent_id == 0) {
			return 'No Parent';
		} else {
			return Category::where(['id' => $parent_id])->value('name');
		}
	}
}
