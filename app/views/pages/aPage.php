<?php

/*
 * abstract class to generate various html pages
 */

namespace views\pages;

const SHOW = true;
const HIDE = false;

abstract class aPage {

	// incoming data
	protected $pageTitle;
	protected $userPanel;
	protected $menuItems;
	protected $headerAddOns;
	protected static $content;
	protected $footer;
	protected $address;
	protected $system;

	// page's parts visibility
	protected $userPanel_visibility  = SHOW;
	protected $searchForm_visibility = HIDE;
	protected $logoRow_visibility    = SHOW;
	protected $mainMenu_visibility   = SHOW;
	protected $header_visibility     = SHOW;
	protected $main_visibility       = SHOW;
	protected $footerRow_visibility  = SHOW;
	protected $footer_visibility     = SHOW;
	protected $address_visibility    = SHOW;

	# --- [[ get section ]]

	protected function get_pageStart() {
		$html = '<!DOCTYPE html>';
		$html .= '<HTML>';
		$html .= '<HEAD>';
		$html .= '<META charset="UTF-8">';
		$html .= '<TITLE>'._SITE_TITLE_.$this->pageTitle.'</TITLE>';
		$html .= '<LINK rel="SHORTCUT ICON" href="/favicon.ico">';
		$html .= '<LINK rel="stylesheet" href="/styles/--normalize.css">';
		$html .= '<LINK rel="stylesheet" href="/styles/main.css">';
		$html .= '<SCRIPT src="/scripts/--jquery-3.2.1.min.js"></SCRIPT>';
		$html .= '<SCRIPT src="/scripts/--selectivizr-min.js"></SCRIPT>';
		$html .= '<SCRIPT src="/scripts/--prefixfree.min.js"></SCRIPT>';
		$html .= '</HEAD>';
		$html .= '<BODY>';
		return $html;
	}

	protected function get_userPanel() {
		if ($this->userPanel_visibility) {
			$html = '<SECTION id="userPanel" class="row">';
			$html .= '<NAV class="span30 offset70">';
			$html .= '<UL>';
			$html .= $this->userPanel;
			$html .= '</UL>';
			$html .= '</NAV>';
			$html .= '</SECTION>';
			return $html;
		}
	}

	protected function get_siteLogo() {
		$html = '<H1 class="span30">';
		$html .= '<A href="">';
		$html .= '<IMG src="/images/logo.png"> Тестове завдання</A>';
		$html .= '</H1>';
		return $html;
	}

	protected function get_searchForm() {
		if ($this->searchForm_visibility) {
			$html = '<FORM class="span20 offset50" processor="special" id="searchForm">';
			$html .= '<INPUT type="search" name="searchString" placeholder="пошук" id="searchString" minlength=3 required accesskey="f">';
			$html .= '<LABEL for="searchString">U</label>';
			$html .= '</FORM>';
			$html .= '<SCRIPT src="/scripts/searchFormTest.js"></SCRIPT>';
			return $html;
		}
	}

	protected function get_logoRow() {
		if ($this->logoRow_visibility) {
			$html = '<SECTION id="siteLogo" class="row">';
			$html .= $this->get_siteLogo();
			$html .= $this->get_searchForm();
			$html .= '</SECTION>';
			return $html;
		}
	}

	protected function get_mainMenu() {
		if ($this->mainMenu_visibility) {
			$html = '<MENU class="row">';
			$html .= '<UL>';
			$html .= $this->menuItems;
			$html .= '</UL>';
			$html .= '</MENU>';
			return $html;
		}
	}

	protected function get_headerAddOns() {
		return $this->headerAddOns;
	}

	protected function get_header() {
		if ($this->header_visibility) {
			$html = '<HEADER>';
			$html .= $this->get_userPanel();
			$html .= $this->get_logoRow();
			$html .= $this->get_mainMenu();
			$html .= $this->get_headerAddOns();
			$html .= '</HEADER>';
			return $html;
		}
	}

	protected function get_main() {
		if ($this->main_visibility) {
			$html = '<MAIN>'.self::$content.'</MAIN>';
			return $html;
		}
	}

	protected function get_footerRow() {
		if ($this->footerRow_visibility) {
			$html = '<UL class="row">';
			$html .= $this->footer;
			$html .= '</UL>';
			return $html;
		}
	}

	protected function get_address() {
		if ($this->address_visibility) {
			$html = '<ADDRESS>';
			$html .= $this->address;
			$html .= '</ADDRESS>';
			return $html;
		}
	}

	protected function get_footer() {
		if ($this->footer_visibility) {
			$html = '<FOOTER class="row">';
			$html .= $this->get_footerRow();
			$html .= $this->get_address();
			$html .= '</FOOTER>';
			return $html;
		}
	}

	protected function get_system() {
		$html = '<SECTION id="system">';
		$html .= '<A href="hide">&#xe051;</A>';
		$html .= '<DIV class="formContainer">';
		$html .= $this->system;
		$html .= '</DIV>';
		$html .= '</SECTION>';
		$html .= '<SCRIPT src="/scripts/userPanel.js"></SCRIPT>';
		$html .= '<SCRIPT src="/scripts/formTest.js"></SCRIPT>';
		return $html;
	}

	protected function get_pageEnd() {
		$html = '</BODY></HTML>';
		return $html;
	}

	protected function get_whole_page() {
		$html = $this->get_pageStart().
		$this->get_header().
		$this->get_main().
		$this->get_footer().
		$this->get_system().
		$this->get_pageEnd();
		return $html;
	}

	# --- [[set section ]]

	protected function set_pageTitle($title) {
		$this->pageTitle .= $title;
	}

	protected function set_userPanel($html) {
		$this->userPanel = $html;
	}

	protected function set_systemSection($html) {
		$this->system = $html;
	}

	protected function set_mainMenu($html) {
		if (!empty($html)) {
			$this->menuItems .= $html;
		}
	}

	protected function set_headerAddOns($html) {
		$this->headerAddOns = $html;
	}

	protected function set_contentSection($content) {
		self::$content = $content;
	}

	# --- [[ hide/show section ]]
	public function __call($method, $args) {
		$operation = substr($method, 0, 4);
		switch ($operation) {
			case 'show':
				$visibility = SHOW;
				break;
			default:
				$visibility = HIDE;
		}

		$pagePartArray = explode('_', $method);

		if (isset($pagePartArray[1])) {
			$pagePart = $pagePartArray[1].'_visibility';

			if (isset($this->$pagePart)) {
				$this->$pagePart = $visibility;
			}
		}
	}
}
