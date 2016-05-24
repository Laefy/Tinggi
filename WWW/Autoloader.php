<?php
class Autoloader{

    /**
     * Enregistre la fonction d'autoload.
     */
    public static function register(){
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }

    /**
     * Inclut le fichier correspondant à notre classe.
     * @param $class string Le nom de la classe à charger.
     */
    public static function autoload($class){
      $path = str_replace('\\',DIRECTORY_SEPARATOR,$class).'.php';
      if (file_exists($path)) {
       include $path;
      }
    }

}
?>
