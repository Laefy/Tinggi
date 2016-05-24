<?php
  class Router{
    private static $correspondanceControl = array(
                                          'Match' => 'controller\PostController'
                                        );

    static function initRouter(){
      define('ROOT',str_replace('index.php','',$_SERVER['SCRIPT_NAME']));
      define('WEBROOT',str_replace('index.php','',$_SERVER['SCRIPT_FILENAME']));
    }

    static function handleRequest($pageToLoad){
      $param = explode('/',$pageToLoad);
      if(!empty($param[1])){
        $controller = $param[0];
        if(array_key_exists($controller, Router::$correspondanceControl)){
          $controller = Router::$correspondanceControl[$controller];
          if(method_exists($controller, $param[1]))
          {
            if(count($param)>2){
              return $controller::$param[1](json_decode($param[2]));
            }
            else {
              return $controller::$param[1]();
            }
          }
        }
        else{
          echo "error 404";
        }
      }
      else if (!empty($param[0])){
        $controller = $param[0];
        if(array_key_exists($controller, Router::$correspondanceControl)){
          $controller = Router::$correspondanceControl[$controller];
          if(method_exists($controller, 'instantiate'))
          {
              return $controller::instantiate();
          }
          else{
            echo "error 404";
          }
        }
      }
    }


  }
?>
