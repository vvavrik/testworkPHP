<?php

namespace views\pages;

require_once __ROOT__.'config/main.php';// site's configuration

/**
 * usual page of the site
 */

class Page extends aPage {

	use \views\elements\HTMLElements;

	private $roller_visibility = HIDE;
	private $roller;
	private $fastAccess;

	public static $asideTitle;
	public static $asideContent;

	public function __construct($title) {
		$this->set_pageTitle($title);
		$this->set_topPanel();
		$this->set_system();
	}

	public function set_pageTitle($title) {
		parent::set_pageTitle($title);
	}

	public function set_topPanel() {
		$user      = new \models\users\User;
		$userData  = $user->get_userData();
		$userLogin = $userData['login'];

		$html = '<LI name="actions">'.$userLogin.'</LI>';
		$html .= '<LI class="icon"><A href="../user/logout">&#77;</A></LI>';

		parent::set_userPanel($html);
	}

	public function set_system() {
	}

	public function set_menu($html) {
		parent::set_mainMenu($html);
	}

	# --- [[ search form ]]

	public function searchForm_visibility($flag) {
		if (strtolower($flag) == 'show') {
			parent::show_searchForm();
		} else {
			parent::hide_searchForm();
		}
	}

	# --- [[ rooler/illustration section ]]

	public function roller_visibility($flag) {
		if (strtolower($flag) == 'show') {
			$this->roller_visibility = SHOW;
			$this->setRollerItems();
			$html = $this->makeRoller();
			parent::set_headerAddOns($html);
		} else {
			$this->roller_visibility = HIDE;
		}
	}

	public function addRollerItem($picture, $title, $subTitle, $target) {
		$this->roller .= ' PIC.push("'.$picture.'"); H2.push("'.$title.'");  H3.push("'.$subTitle.'"); TARGET.push("'.$target.'"); ';
	}

	public function addFastAccessItem($title, $symbol, $target) {
		$this->fastAccess .= ' FAST_ACCESS_TITLE.push("'.addslashes($title).'"); FAST_ACCESS_SYMBOL.push("'.addslashes($symbol).'"); FAST_ACCESS_TARGET.push("'.addslashes($target).'"); ';
	}

	public function makeRoller() {
		$html = '<SECTION id="illustr" class="row" target=""><DIV class="span40 offset60"><H2></H2><H3></H3></DIV>';
		$html .= '<UL><SCRIPT>';
		$html .= 'var PIC = []; var H2 = []; var H3 = []; TARGET= []; ';
		$html .= $this->roller;
		$html .= 'var FAST_ACCESS_TITLE = []; var FAST_ACCESS_SYMBOL = []; var FAST_ACCESS_TARGET = [];';
		$html .= $this->fastAccess;
		$html .= '</SCRIPT></UL></SECTION>';
		$html .= '<SCRIPT src="/scripts/roller.js"></SCRIPT>';
		$html .= '<SCRIPT src="/scripts/fastAccessIcons.js"></SCRIPT>';
		return $html;
	}

	public function setRollerItems() {
	}

	public static function set_asideTitle($title) {
		self::$asideTitle = $title;
	}

	public static function set_asideContent($content) {
		self::$asideContent = $content;
	}

	public static function set_aside() {
		$html = '<ASIDE>';
		$html .= '<H2>'.self::$asideTitle.'</H2>';
		$html .= '<UL>'.self::$asideContent.'</UL>';
		$html .= '</ASIDE>';
		parent::$content .= $html;
	}

	public function setMain() {

	}

	public function showPage() {
		return parent::get_whole_page();
	}
}