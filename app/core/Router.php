<?php

namespace core;

final class Router {

	public static $URIController;
	public static $URIAction;
	public static $URIParameters;

	private $routes;

	public function __construct() {
		$routesPath   = __DIR__ .'/../../config/routs.php';
		$this->routes = require_once ($routesPath);
	}

	/**
	 * Returns URI string
	 * @return string
	 */
	private function getURI() {
		if (!empty($_SERVER['REQUEST_URI'])) {
			return trim($_SERVER['REQUEST_URI'], '/');
		}
	}

	/**
	 * Find controller class and action due to URI
	 */
	public function run() {
		$find = false;
		$uri  = $this->getURI();// get uri from user's request
		foreach ($this->routes as $URIPattern => $actionPath) {// find out if uri is in defined routes
			if (preg_match("~$URIPattern~", $uri)) {// find current uri in defined routes
				$internalRoute       = preg_replace("~$URIPattern~", $actionPath, $uri);
				$segments            = explode('/', $internalRoute);// find out which controller and action will work on this uri
				self::$URIController = array_shift($segments);
				$controllerName      = self::$URIController.'Controller';// controller name
				$controllerName      = ucfirst($controllerName);// uppercase first letter because this is class file
				$controllerName      = '\controllers\\'.$controllerName;

				$actionName = 'action'.ucfirst(array_shift($segments));// action name

				$parameters = $segments;// action's parameters - all that left
				require_once ('loader.php');// autoloader of the classes
				$controllerObject = new $controllerName;// create an object, run an action
				$result           = call_user_func_array(array($controllerObject, $actionName), $parameters);
				if ($result != null) {
					$find = true;
					break;// uri was processed - exit
				}
			}
		}
		if (!$find) {
			# show default page
			require_once ('loader.php');
			$controllerObject = new \controllers\WelcomeController;
			$controllerObject->actionStart();
		}
	}
}