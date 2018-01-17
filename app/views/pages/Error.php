<?php

namespace views\pages;

/**
 * page to show text messages
 */

final class Error extends \views\pages\aMessage {

	public function __construct($title, $message, $URI) {
		parent::setWindowProperties('Збій в роботі.', 'errorMessage');
		echo parent::createWindow($title, $message, $URI);
	}
}
