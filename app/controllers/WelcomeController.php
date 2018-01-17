<?php

/*
 * Class for the start page of the site
 */

namespace controllers;

class WelcomeController {

	public function actionStart() {
		require_once (__ROOT__.'public/pages/start.php');
		return true;
	}

	public function actionWelcome() {
		require_once (__ROOT__.'public/pages/lobby.php');
		exit;
	}

	public function actionError() {
		header('Location: ../');
		exit;
	}
}
