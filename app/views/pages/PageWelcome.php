<?php

namespace views\pages;

require_once __ROOT__.'config/main.php';// site's configuration

/**
 * index page
 */

class PageWelcome extends aPage {

	use \views\elements\HTMLElements;

	protected $userPanel;
	protected $system;

	public function userPanel_addItem($name, $title) {
		$html = $this->make_ListElement($name, $title);
		$this->userPanel .= $html;
	}

	public function system_addForm($html) {
		$this->system .= $html;
	}

	protected function make_contentSection() {
		$html = '<SECTION class="booklet" class="row">';
		$html .= '<ARTICLE>';
		$html .= '<H2>'._SITE_MOTTO_.'</H2>';
		$html .= '<H3>'._SITE_SLOGAN_.'</H3>';
		$html .= '<IMG src="/images/booklet/zaporizhObl.png" alt="Мапа Запорізької області">';
		$html .= '</ARTICLE>';
		$html .= '</SECTION>';
		return $html;
	}

	public function showPage() {
		parent::set_pageTitle('Ласкаво просимо!');
		parent::set_userPanel($this->userPanel);
		parent::set_contentSection($this->make_contentSection());
		parent::set_systemSection($this->system);
		parent::hide_mainMenu();
		parent::hide_footer();
		echo parent::get_whole_page();
	}
}
