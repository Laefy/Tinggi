<?php
class Accessor {

    public static function get($element, $type){
      if(isset($_GET[$element]))
      {
        return $_GET[$element];
      }
      return '';
    }

    public static function post($element, $type) {
      if(isset($_POST[$element])) {
        return $_POST[$element];
      }
      return '';
    }

    public static function file($element, $type) {
      /*
      $target = $_SERVER['DOCUMENT_ROOT'].$target;
      $max_size = 10000;
      $max_width = 1000;
      $max_height = 1000;
      $tabExt = array('jpg','gif','png','jpeg');    // Extensions autorisees
      $infosImg = array();
      $extension = '';
      $message = '';
      $nomImage = '';


      if(!empty($_FILES['fichier']['name']) )
      {
        $extension  = pathinfo($_FILES['fichier']['name'], PATHINFO_EXTENSION);
        if(in_array(strtolower($extension),$tabExt))
        {
          $infosImg = getimagesize($_FILES['fichier']['tmp_name']);
          if($infosImg[2] >= 1 && $infosImg[2] <= 14)
          {

            if(($infosImg[0] <= $max_width) && ($infosImg[1] <= $max_height) && (filesize($_FILES['fichier']['tmp_name']) <= $max_size))
            {
              if(isset($_FILES['fichier']['error']) && UPLOAD_ERR_OK === $_FILES['fichier']['error'])
              {
                $img = uniqid().'.'. $extension;
                if(move_uploaded_file($_FILES['fichier']['tmp_name'], $target.$img)) return $img;
                else return false;
              }
            }
          }
        }
      }
      */
    }

    public static function checkPost($elements) {
      $postElements = [];
      foreach ($elements as $key => $value) {
        if((!isset($_POST[$key])) || (empty($_POST[$key])))
        {
          return ['Le champ "'.$key.'" n\'est pas complété.'];
        }
        array_push($postElements,[$_POST[$key] => $value]);
      }
      return self::check($postElements);
    }

    public static function checkGet($elements) {
      $getElements = [];
      foreach ($elements as $key => $value) {
        if(!isset($_GET[$key]))
        {
          return ['Le champ "'.$key.'" n\'est pas complété.'];
        }
        array_push($getElements,[$_GET[$key] => $value]);
      }
      return self::check($getElements);
    }

    private static function check($elements) {
      $errors = [];
      foreach ($elements as $var => $param) {
        switch(key(reset($param))) {
          case 'number' :
            self::haveError($errors,self::checkNumber(key($param),reset($param)));
          break;
          case 'string' :
            self::haveError($errors,self::checkString(key($param),reset($param)));
          break;
          case 'comp' :
            self::haveError($errors,self::compString(key($param),reset($param)));
          break;
          case 'file' :
            self::haveError($errors,self::checkFile(key($param),reset($param)));
          break;
        }
      }
      return $errors;
    }

    private static function haveError($errors,$check)
    {
      $error = $check;
      if($error) array_push($errors,$check);
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
            return false;
          break;
          case 'max' :
            if($num > $value)
            {
              return '"'.$num.'" est un nombre trop grand';
            }
            return false;
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
            return false;
          break;

          case 'max' :
            if(strlen($var) > $value)
            {
                return '"'.$var.'" est une chaine trop grande';
            }
            return false;
          break;
        }
      }
    }

    private static function compString($var,$param){
      if(strcmp($var,reset($param['comp'])) == 0){
            return false;
      }
      return 'Les chaines ne sont pas idetiques';

    }

    private static function checkFile($var,$param){
        return false;
    }
}
?>
