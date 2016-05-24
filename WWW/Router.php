<?php
  class Router{
    private static var $correspondancePage = array(
                                          'index' =>  ,
                                          'lolilol' => ,
                                        );
    private static var $correspondanceControl = array(
                                          'index' =>  ,
                                          'lolilol' =>
                                        );


    private static function initRouter(){
      define('ROOT',str_replace('index.php','',$_SERVER['SCRIPT_NAME']));
      define('WEBROOT',str_replace('index.php','',$_SERVER['SCRIPT_FILENAME']));
    }

    static function redirection($pageToLoad){
      $param = explode('/',$pageToLoad);
      if(count($param)>1){
        $controller = $param[0];
        if(array_key_exists($controller, $correspondanceControl)){
          $controller = new $correspondanceControl[$controller];
          if(method_exists($controller, $param[1]))
          {
            if(count($param)>2){
              $controller->$param[1](json_decode($param[2]));
            }
            else {
              $controller->$param[1]();
            }
          }
        }
        else{
          echo "error 404";
        }
      }
      else if (!empty($param[0])){
        $controller = $param[0];
        if(array_key_exists($controller, $correspondanceControl)){
          $controller = new $correspondanceControl[$controller];
          if(method_exists($controller, 'index'))
          {
              $controller->index();
          }
          else{
            echo "error 404";
          }
        }
      }
    }


  }
?>
