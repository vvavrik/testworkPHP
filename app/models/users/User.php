<?php

namespace models\users;

class User {

	use \core\DataProcess;

	private $userID;
	private $userPassword;
	private $userLogin;

	public function __construct() {
		$this->userTest();
	}

	private function userTest() {
		if (empty($_SESSION['userID']) or empty($_SESSION['userLogin']) or empty($_SESSION['userPassword'])) {
			throw new \Exception('Вибачте. Відбувся збій в роботі сайту. Спробуйте пройти авторизацію ще раз.');
			exit;
		}

		$userLogin    = $this->clearString($_SESSION['userLogin']);
		$userPassword = $this->clearString($_SESSION['userPassword']);
		$userID       = (integer) $_SESSION['userID'];

		$where = 'login = "'.$userLogin.'" AND password = "'.$userPassword.'" AND id = '.$userID;
		$row   = \core\Database::$DB->select('*', 'users', $where, 'id LIMIT 1');

		if ($row['number'] == 0) {
			throw new \Exception('Збій автентифікації. Такого користувача не існує.');
			exit;
		}

		$this->userLogin    = $userLogin;
		$this->userPassword = $userPassword;
		$this->userID       = $userID;
	}

	public function get_userData() {
		$user = array('id' => $this->userID, 'login' => $this->userLogin);
		return $user;
	}

	public static function logout() {
		$_SESSION["userID"]       = '';
		$_SESSION["userLogin"]    = '';
		$_SESSION["userPassword"] = '';
	}
}