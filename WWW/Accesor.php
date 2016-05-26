<?php
class Accesor {

    public static get($element, $type){
      return $_GET[$element];
    }
    public static post($element, $type){
      return $_POST[$element];
    }

    public static function checkPost($elements) {
      $postElements = [];
      foreach ($elements as $key => $value) {
        if(!isset($_POST[$key]))
        {
          return ['le champs "'.$key.'" n\'est pas complété'];
        }
      }
      return self::check($postElements);
    }

    public static function checkGet($elements) {
      $getElements = [];
      foreach ($elements as $key => $value) {
        if(!isset($_GET[$key]))
        {
          return ['le champs "'.$key.'" n\'est pas complété'];
        }
      }
      return self::check($getElements);
    }

    private static function check($elements) {
      $error = []
      foreach ($elements as $var => $param) {
        switch($param[0]) {
          case 'number' :
            array_push($error,self::checkNumber($var,$param));
          break;
          case 'string' :
            array_push($error,self::checkString($var,$param));
          break;
          case 'comp' :
            array_push($error,self::compString($var,$param));
          break;
        }
      }
      return $error;
    }

    private static function checkNumber($var,$param){
      $num = intval($var);
      foreach ($param['number'] as $key => $value) {
        switch($key) {
          case 'min' :
            if($num < $value)
            {
                return '"'.$num.'" n\'est pas un nombre assez grand';
            }
          break;
          case 'max' :
            if($num > $value)
            {
              return '"'.$num.'" est un nombre trop grand';
            }
          break;
        }
      }
    }

    private static function checkString($var,$param){
      foreach ($param['string'] as $key => $value) {
        switch($key) {
          case 'min' :
            if(strlen($var) < $value)
            {
                return '"'.$var.'" n\'est pas une chaine assez grande';
            }
          break;

          case 'max' :
            if(strlen($var) > $value)
            {
                return '"'.$var.'" est une chaine trop grande';
            }
          break;
        }
      }
    }

    private static function compString($var,$param){
      if(strcmp($var,$param[0]) != 0){
            return '"'.$var.'" est une chaine incorrecte.';
      }
    }
}
?>
