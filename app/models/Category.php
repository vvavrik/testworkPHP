<?php

namespace models;

class Category {

	private $category_id;
	private $category_title;

	public static function get_allCategories() {
		$row = \core\Database::$DB->select('*', 'goods_category', '', 'title');
		return $row['result'];
	}

}
