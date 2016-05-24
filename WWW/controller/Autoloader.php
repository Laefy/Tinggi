<?php
  class Autoloader{

      /**
       * Enregistre la fonction d'autoload.
       */
      static function register(){
          spl_autoload_register(array(__CLASS__, 'autoload'));
      }

      /**
       * Inclut le fichier correspondant à notre classe.
       * @param $class string Le nom de la classe à charger.
       */
      static function autoload($class){
          include str_replace('\\',DIRECTORY_SEPARATOR,$class).'.php';
      }

  }
?>
