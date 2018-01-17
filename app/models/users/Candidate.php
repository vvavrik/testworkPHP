<?php

namespace models\users;

class Candidate {

	use \core\DataProcess;

	private $name;
	private $password;
	private $passwordConfirm;

	private function clearMainInputData() {
		$this->name     = $this->clearInputString('name', 6, 20);
		$this->password = $this->clearInputString('password', 6, 20);
	}

	private function clearSecondaryInputData() {
		$this->passwordConfirm = $this->clearInputString('passwordConfirm', 6, 20);
	}

	public function preRegistrationTest() {
		$this->clearMainInputData();
		$this->clearSecondaryInputData();

		if ($this->password != $this->passwordConfirm) {
			throw new \Exception('Пароль введено не вірно. Впевніться, що в поле "Пароль" та "Підтвердження паролю" введено одне і те саме значенняs.');
			exit;
		}

		$num_rows = \core\Database::$DB->selectNumberRows('users', 'login', $this->name);
		if ($num_rows == 1) {
			throw new \Exception('Користувач з таким ім’ям вже зареєстрований в системі. Зв’яжіться з адміністратором для відновленя паролю.');
			exit;
		}
		$this->password = addslashes(crypt($this->password, "@xtraStr0ngC0ff33"));

		return true;
	}

	public function register() {
		$KEYS   = array('login', 'password', 'IP');
		$VALUES = array($this->name, $this->password, $_SERVER["REMOTE_ADDR"]);
		\core\Database::$DB->insert('users', $KEYS, $VALUES);

		$title   = 'Реєстрація завершена!';
		$message = 'Поздоровляємо! Ви успішно зареєструвались у системі. Тепер Ви можете зайти у систему, використовуючи Ваші ім’я та пароль';
		$URI     = '../';
		$message = new \views\pages\Message($title, $message, $URI);
	}

	public function testIncomingUser() {
		$this->clearMainInputData();
		$this->password = addslashes(crypt($this->password, "@xtraStr0ngC0ff33"));
		$where          = 'login = "'.$this->name.'" AND password = "'.$this->password.'"';
		$row            = \core\Database::$DB->select('*', 'users', $where, 'id LIMIT 1');

		if ($row['number'] == 0) {
			throw new \Exception('Користувач з такими ім`ям `'.$this->name.'` і паролем в системі не знайдений. Можливо, необхідно зареєструватись у системі?');
			exit;
		}

		$_SESSION["userID"]       = $row['result'][0]["id"];
		$_SESSION["userLogin"]    = $row['result'][0]["login"];
		$_SESSION["userPassword"] = $row['result'][0]["password"];

		return true;
	}
}