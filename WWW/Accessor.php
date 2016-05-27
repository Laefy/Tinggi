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
      if($type == "file"){
        print_r($_POST);
        if(isset($_FILES[$element])){
          return $_FILES[$element];
        }
        return '';
      }

      if(isset($_POST[$element])) {
        return $_POST[$element];
      }
      return '';
    }

    static function saveFile($file, $targetName) {

      $destination = \Router::$WEBROOT."data/upload/".$targetName;

      if(move_uploaded_file ($file , $destination)) return true;
      return false;
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
      return 'Les chaines ne sont pas identiques.';

    }

    static function checkFile($var,$param){

      if ($_FILES[$var]['error']) {
          switch ($_FILES['nom_du_fichier']['error']){
                   case 1: // UPLOAD_ERR_INI_SIZE
                    return "Le fichier dépasse la limite autorisée par le serveur (fichier php.ini) !";
                   break;
                   case 2: // UPLOAD_ERR_FORM_SIZE
                    return "Le fichier dépasse la limite autorisée dans le formulaire HTML !";
                   break;
                   case 3: // UPLOAD_ERR_PARTIAL
                    return "L'envoi du fichier a été interrompu pendant le transfert !";
                   break;
                   case 4: // UPLOAD_ERR_NO_FILE
                    return "Le fichier que vous avez envoyé a une taille nulle !";
                   break;
          }
      }
      $max_size = $param["maxsize"];
      $max_width = $param["resolution"];
      $max_height = $param["resolution"];
      $tabExt = array('jpg','gif','png','jpeg');    // Extensions autorisees

      $extension = array();
      $message = '';
      $nomImage = '';

      if(!empty($_FILES[$var])) {
        $extension  = pathinfo($_FILES[$var]['name'], PATHINFO_EXTENSION);
        if(in_array(strtolower($extension),$tabExt)) {
          $infosImg = getimagesize($_FILES[$var]['tmp_name']);
          if($infosImg[2] >= 1 && $infosImg[2] <= 14) {
            if(($infosImg[0] <= $max_width) && ($infosImg[1] <= $max_height) && (filesize($_FILES[$var]['tmp_name']) <= $max_size)) {
                return false;
            }
            return "La taille du fichier uploadé est trop grande.";
          }
          return "Le format du fichier uploadé n'est pas supporté.";
        }
        return "Le type du fichier uploadé n'est pas supporté.";
      }
      return "Le fichier uploadé n'existe pas.";
    }
}
?>
