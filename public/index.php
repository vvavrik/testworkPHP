<?php

/*
 * Front Controller
 */

session_start();

define('__ROOT__', __DIR__ .'/../');

// basic settings
ini_set('display_errors', 1);
error_reporting(E_ALL);

// site's main config file
require_once (__ROOT__.'config/main.php');

// include system files - autoloader for the classes
require_once (__ROOT__.'app/core/loader.php');

try {
	// connect to db
	$db                 = new \core\Database;
	\core\Database::$DB = $db;
	$router             = new \core\Router;
	$router->run();
}
 catch (Exception $e) {
	$title   = 'Помилка в роботі сайту';
	$message = $e->getMessage();
	$message .= '<br><b><i>file:</i></b> '.$e->getFile();
	$message .= '<br><b><i>trace:</i></b> '.$e->getTraceAsString();

	$URI     = \core\Router::$URIController.'\error';
	$message = new \views\pages\Error($title, $message, $URI);
	exit;
}