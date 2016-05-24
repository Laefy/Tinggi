<?php
namespace controller;

  class Main{

    private var $datas = array();

    static function initWeb(){
        session_start();
        require_once("./Controller/Autoloader.php");
        Autoloader::register();
    }

    function setDatas($datas){
        $this->datas = array_merge($this->datas,$datas);
    }

    function render($filename){
        extract($datas);
        require WEBROOT.'view/'.get_class($this).'/'.$filename.'.php';
    }
  }
?>
