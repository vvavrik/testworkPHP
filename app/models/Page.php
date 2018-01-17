<?php

namespace models;

class Page {

	use \core\DataProcess;
	use \views\elements\HTMLElements;

	public static $page;
	private static $mainMenu;

	public function __construct($title) {
		self::$page = new \views\pages\Page($this->clearString($title));
		$this->set_menu();
	}

	public function searchForm_visibility($flag) {
		self::$page->searchForm_visibility($flag);
	}

	# -------- [[ Main Menu Section ]]

	private function addMenuElement($href, $title) {
		$html = '<LI>'.$this->make_Anchor($href, $title).'</LI>';
		return $html;
	}

	private function set_menu() {
		$html = $this->addMenuElement('../welcome', 'Головна');
		// select all menu elements due to my access level
		self::$page->set_menu($html);
	}

	public function roller_visibility($flag) {
		self::$page->roller_visibility($flag);
	}

	public function set_aside($table) {
		\views\pages\Page::set_asideTitle('Категорії товару');
		$categories = Category::get_allCategories();
		var_dump($categories);
		exit;
		\views\pages\Page::set_asideContent($categories);
		\views\pages\Page::set_aside();
	}

	private function setMainSection($html) {
		parent::set_contentSection($html);
	}

	public function showPage() {
		echo self::$page->showPage();
	}

}
