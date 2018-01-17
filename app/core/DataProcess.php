<?php

namespace core;

trait DataProcess {

	private function clearString($value) {
		$value = trim($value);
		$value = stripslashes($value);
		$value = strip_tags($value);
		$value = htmlspecialchars($value);
		$value = addslashes($value);
		return $value;
	}

	public function isFileExists($fileName) {
		if (file_exists(__ROOT__.$fileName)) {
			return true;
		}
	}

	public function clearInputString($key, $minLength, $maxLength) {
		$this->key       = $key;
		$this->minLength = $minLength;
		$this->maxLength = $maxLength;

		if (!empty($_POST[$key])) {
			$value = $this->clearString($_POST[$key]);
		} else {
			throw new \Exception('Не заповнене необхідне поле `'.$key.'`! Перевірте заповненість усіх необхідних полів.');
			exit;
		}

		if (isset($minLength)) {
			if (strlen($value) < $minLength) {
				throw new \Exception('Обов`язкове поле має недостатню довжину! Мінімальна довжина '.$minLength.' символів.');
				exit;
			}
		}

		if (isset($maxLength)) {
			if (strlen($value) > $maxLength) {
				throw new \Exception('Обов`язкове поле занадто довге! Максимальна довжина '.$maxLength.' символів.');
				exit;
			}
		}
		return $output['value'] = $value;
	}

	public function clearInputInteger($key, $minLength, $maxLength) {
		$this->key       = $key;
		$this->minLength = $minLength;
		$this->maxLength = $maxLength;

		if (!empty($_POST[$key])) {
			$value = (integer) $_POST[$key];
		} else {
			throw new \Exception('Усі обов`язкові поля не заповнені! Перевірте заповненість усіх необхідних полів.');
			exit;
		}

		if (isset($minLength)) {
			if (strlen($value) < $minLength) {
				throw new \Exception('Обов`язкове поле має недостатню довжину! Мінімальна довжина '.$minLength.' символів.');
				exit;
			}
		}

		if (isset($maxLength)) {
			if (strlen($value) > $maxLength) {
				throw new \Exception('Обов`язкове поле занадто довге! Максимальна довжина '.$maxLength.' символів.');
				exit;
			}
		}
		return $output['value'] = $value;
	}

	public function clearSessionString($key) {
		$this->key = $key;

		$output = [];

		if (!empty($_SESSION[$key])) {
			$value = $this->clearString($_SESSION[$key]);
		} else {
			throw new \Exception('Помилка авторизації!');
			exit;
		}
		return $output['value'] = $value;
	}

	public function downloadPicture($id, $input, $directory) {
		if ($_FILES[$input]["size"] == 0) {
			throw new \Exception('До завантаження передано пустий файл.');
			exit;
		}

		if (!is_uploaded_file($_FILES[$input]["tmp_name"])) {
			throw new \Exception('Неможливо обробити завантажений файл.');
			exit;
		}

		$allowedFileTypes = array('.jpg');

		$fileName = $_FILES[$input]['name'];
		$fileType = substr($fileName, strpos($fileName, '.'), strlen($fileName)-1);
		if (!in_array($fileType, $allowedFileTypes)) {
			throw new \Exception('До завантаження допускаються лише JPG зображення. Завантаженний файл має тип '.$fileType);
			exit;
		}

		$maxFileSize = 2000000;
		if (filesize($_FILES[$input]['tmp_name']) > $maxFileSize) {
			throw new \Exception('Ваш файл занадто великий для завантаження. Спробуйте зменшити розмір файлу.');
			exit;
		}

		$addr = $_SERVER["DOCUMENT_ROOT"].'/files/'.$directory.'/';
		if (!is_writable($addr)) {
			throw new \Exception('Немає доступу до файлової директорії.'.$addr);
			exit;
		}

		$addrFile = $addr.$id.'.jpg';
		if (!move_uploaded_file($_FILES[$input]['tmp_name'], $addrFile)) {
			throw new \Exception('Під час завантаження файлу відбувся збій.');
			exit;
		}

		$neww     = 300;// width px
		$newh     = 240;// height px
		$quality  = 70;// quality %
		$addrIcon = $addr.$id.'_s.jpg';

		$original = imagecreatefromjpeg($addrFile);
		$icon     = imagecreatetruecolor($neww, $newh);
		imagecopyresampled($icon, $original, 0, 0, 0, 0, $neww, $newh, imagesx($original), imagesy($icon));
		imagejpeg($icon, $addrIcon, $quality);
		imagedestroy($original);
		imagedestroy($icon);

		return true;
	}
}
