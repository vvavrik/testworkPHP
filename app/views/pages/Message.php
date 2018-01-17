<?php

namespace views\pages;

/**
 * page to show text messages
 */

final class Message extends \views\pages\aMessage {

	public function __construct($title, $message, $URI) {
		parent::setWindowProperties('Готово!', 'message');
		echo parent::createWindow($title, $message, $URI);
	}

}
