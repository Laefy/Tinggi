<?php
class MainController{
	static function initRouter(){
		define('ROOT',str_replace('index.php','',$_SERVER['SCRIPT_NAME']));
		define('WEBROOT',str_replace('index.php','',$_SERVER['SCRIPT_FILENAME']));	
		
		$param = explode('/',$_GET['p']);
	
		$page = $param[0];
		$action = isset($param[1]) ? $param[1] : 'index';
		require ("controller/$page.php");
		$controller=new $page();		
		if(method_exists($controller,$action)){		
			$controller->$action(); 	
		}
	
		else{
			echo "error 404";
		}
	}
}
?>