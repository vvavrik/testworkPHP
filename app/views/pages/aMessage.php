<?php

namespace views\pages;

abstract class aMessage extends \views\pages\aPage {

	protected $messageTitle;
	protected $messageContent;
	protected $redirectPage;

	protected $windowClass;
	protected $windowTitle;

	protected function setWindowProperties($title, $class) {
		$this->windowTitle = $title;
		$this->windowClass = $class;
	}

	public function createWindow($title, $message, $redirectPage) {
		$this->messageTitle   = $title;
		$this->messageContent = $message;
		$this->redirectPage   = $redirectPage;

		parent::set_pageTitle($this->windowTitle);
		parent::hide_header();
		parent::hide_footer();

		$html = '<DIV class="wrapper">';
		$html .= '<ARTICLE class="span60 offset20 '.$this->windowClass.'">';
		$html .= '<H2>'.$this->messageTitle.'</H2>';
		$html .= '<P>'.$this->messageContent.'</P>';
		$html .= '<A href="/'.$this->redirectPage.'">далі</A>';
		$html .= '</ARTICLE>';
		$html .= '</DIV>';
		parent::set_contentSection($html);

		return parent::get_whole_page();
	}
}