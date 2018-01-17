<?php

namespace controllers;

/**
 * Description of UserController
 *
 * @author vav
 */

class UserController {

	public function actionRegister() {
		$candidate = new \models\users\Candidate;
		if ($candidate->preRegistrationTest()) {
			$candidate->register();
		} else {
			throw new Exception('Під час реєстрації відбувся збій! Спробуйте зареєструватись трошки пізніше.');
			exit;
		}
		return TRUE;
	}

	public function actionLogin() {
		$candidate = new \models\users\Candidate;
		$candidate->testIncomingUser();
		header('Location: /welcome');
		exit;
	}

	public function actionLogout() {
		\models\users\User::logout();
		$title   = 'Завершення роботи';
		$message = 'Сесію завершено. До побачення.';
		$URI     = '../';
		$message = new \views\pages\Message($title, $message, $URI);
		exit;
	}

	public function actionError() {// if some error happened - show start page
		$controller = new \controllers\WelcomeController;
		$controller->actionStart();
		exit;
	}
}