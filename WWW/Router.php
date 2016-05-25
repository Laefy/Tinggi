<?php
use view\Response as Response;

class Router {

  public static $ROOT;
  public static $WEBROOT;
	private static $routes = array();

	public static function init() {
		self::$ROOT =  str_replace('index.php','',$_SERVER['SCRIPT_NAME']);
		self::$WEBROOT = str_replace('index.php','',$_SERVER['SCRIPT_FILENAME']);
	}

	public static function addRoute($pattern, $controller, $method) {
		$pattern = '/^' . str_replace('/', '\/', $pattern) . '$/';
		self::$routes[$pattern] = array(new $controller(), $method);
	}

	public static function execute($uri) {
		foreach (self::$routes as $pattern => $callback) {
			if (preg_match($pattern, $uri, $params)) {
				array_shift($params);
				return call_user_func_array($callback, array_values($params));
			}
		}
    $response = new Response('error');
    $response->send(array( 'title' => 'Error 404', 'msg' =>"Url incorrect! Boufon!"));
  }
}
?>
