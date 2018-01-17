<?php

namespace core;

require_once (__ROOT__.'config/database.php');
require_once (__ROOT__.'app/core/loader.php');

class Database extends \PDO {

	use \core\DataProcess;

	public static $PDO;
	public static $DB;

	public function __construct() {
		$currentPage = substr($_SERVER["PHP_SELF"], 7);
		if (!isset(self::$PDO)) {
			$dsn       = "mysql:host=".HOST.";dbname=".DB.";charset=utf8";
			self::$PDO = new \PDO($dsn, USER, PASS);
			self::$PDO->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		}
	}

	public function selectNumberRows($table, $column, $value) {
		$stmt = self::$PDO->prepare("SELECT * FROM $table WHERE $column = :value");
		$stmt->bindParam(":value", $value);
		$stmt->execute();
		return $stmt->rowCount();
	}

	public function uniqueValue($table, $column, $value, $title) {
		$stmt = self::$PDO->prepare("SELECT * FROM $table WHERE $column = :value");
		$stmt->bindParam(":value", $value);
		$stmt->execute();
		$num_rows = $stmt->rowCount();
		if ($num_rows == 0) {
			return true;
		} else {
			throw new Exception('Поле "'.$title.'" вимагає унікальних значень. Введенне значення "'.$value.'" вже існує в базі даних. Спробуйте ввести інше значення.');
			exit;
		}
	}

	public function select($what, $from, $where, $orderBy) {
		$SQL = "SELECT $what FROM $from ";
		if ((isset($where)) and (strlen($where) > 0)) {
			$SQL .= " WHERE ".$where;
		}
		if (strlen($orderBy) > 1) {
			$SQL .= ' ORDER BY '.$orderBy;
		}
		$stmt = self::$PDO->prepare($SQL);
		$stmt->execute();
		$stmt = array('result' => $stmt->fetchAll(\PDO::FETCH_ASSOC), 'number' => $stmt->rowCount());
		return $stmt;
	}

	public function insert($table, $KEYS, $VALUES) {
		if ((count($KEYS) > 0) and (count($KEYS) == count($VALUES))) {
			$SQL = "INSERT INTO $table (";
			foreach ($KEYS as $val) {
				$SQL .= $this->clearString($val).',';
			}
			$SQL = substr($SQL, 0, -1);
			$SQL .= ") VALUES (";
			foreach ($VALUES as $val) {
				$SQL .= "'".$this->clearString($val)."',";
			}
			$SQL = substr($SQL, 0, -1);
			$SQL .= ")";
		}
		$stmt = self::$PDO->prepare($SQL);
		$stmt->execute();
		if ($stmt->rowCount() > 0) {
			return self::$PDO->lastInsertId();
		} else {
			throw new Exception('Не вдалося додати дані в базу даних!');
			exit;
		}

	}

	public function update($table, $set, $where) {
		$SQL  = "UPDATE $table SET $set WHERE $where";
		$stmt = self::$PDO->prepare($SQL);
		$stmt->execute();
		return $stmt->rowCount();
	}

	public function delete($table, $where, $redirectTo, $redirectKey) {
		$SQL  = "DELETE FROM $table WHERE $where";
		$stmt = self::$PDO->prepare($SQL);
		$stmt->execute();
		return $stmt->rowCount();
	}
}
