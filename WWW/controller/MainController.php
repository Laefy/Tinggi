<?php
namespace controller;

  class MainController{
  	static function initRouter(){
  		define('ROOT',str_replace('index.php','',$_SERVER['SCRIPT_NAME']));
  		define('WEBROOT',str_replace('index.php','',$_SERVER['SCRIPT_FILENAME']));

  		$param = explode('/',$_GET['p']);

  		$page = isset($param[0]) ? $param[0] : 'index';
  		$action = isset($param[1]) ? $param[1] : 'index';
      if(class_exists($page,true)){
        $controller= new $page();
        if(method_exists($controller,$action)){
          $controller->$action();
        }
        else{
          echo "error 404";
        }
      }
  		else{
  			echo "error 404";
  		}
  	}
  }
?>
