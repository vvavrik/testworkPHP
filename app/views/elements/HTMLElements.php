<?php

namespace views\elements;

trait HTMLElements {

	public function make_ButtonAnchor($href, $title) {
		$html = '<A href="'.$href.'" class="button">'.$title.'</A>';
		return $html;
	}

	public function make_Anchor($href, $title) {
		$html = '<A HREF="'.$href.'">'.$title.'</A>';
		return $html;
	}

	public function make_ListElement($name, $title) {
		$html = '<LI';
		if (strlen($name) > 0) {
			$html .= ' name="'.$name.'"';
		}
		$html .= '>'.$title.'</LI>';
		return $html;
	}

	public function make_List($listArray) {
		$html = '<UL>';
		foreach ($listArray as $element) {
			$html .= '<LI>'.$element.'</LI>';
		}
		$html .= '</UL>';
		return $html;
	}

	public function make_NumList($listArray) {
		$html = '<OL>';
		foreach ($listArray as $element) {
			$html .= '<LI>'.$element.'</LI>';
		}
		$html .= '</OL>';
		return $html;
	}

	public function make_Input($name, $title, $type, $minLength, $maxLength, $required) {
		$html = '<DIV><INPUT type="'.$type.'" name="'.$name.'" ';
		if ((integer) $minLength > 0) {
			$html .= 'minlength='.(integer) $minLength.' ';
		}
		if ((integer) $maxLength > 0) {
			$html .= 'maxlength='.(integer) $maxLength.' ';
		}
		if ($required == 'required') {
			$html .= 'required ';
		}
		$html .= '><LABEL for="'.$name.'">'.$title.'</LABEL></DIV>';
		return $html;
	}

	protected function make_NavigationTabs($redirectTo, $elementArray) {
		$html = '<DIV class="navigationTabs"><UL>';
		$html .= '<A href="'.$redirectTo.'"><LI>&#xE074;</LI></A>';
		if (is_array($elementArray)) {
			foreach ($elementArray as $key => $value) {
				$html .= '<A href="'.$redirectTo.'?key='.$key.'"><LI>'.$value.'</LI></A>';
			}
		}
		$html .= '</UL></DIV>';
		$this->pagePartBody_main_articleNavigation = $html;
	}

	protected function make_systemSection() {
		$html = '<SECTION id="system">';
		$html .= '<A href="hide">&#xe051;</A>';
		$html .= $this->system;
		$html .= '</SECTION>';
		$html .= '<SCRIPT src="/scripts/userPanel.js"></SCRIPT>';
		$html .= '<SCRIPT src="/scripts/formTest.js"></SCRIPT>';
		return $html;
	}
}