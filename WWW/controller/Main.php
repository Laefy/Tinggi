<?php
namespace controller;

  class Main{

    private $datas = array();
    private $title;

    public function renderView($filename){
      if(isset($datas))
        extract($datas);
      require WEBROOT.'view/'.$filename.'.php';
    }

    public function __construct($title){
        $this->title = $title;
    }

    public function init(){
    }

    public function setDatas($datas){
        $this->datas = array_merge($this->datas,$datas);
    }

    public function render(){
    }

    function buildHeader($style, $icon){
          echo
          '<link rel="stylesheet" href="',WEBROOT,'data/css/',$style,'"/>
          <link rel="icon" type="image/x-png" href="',WEBROOT,'data/img/',$icon,'" />
          <title>',$this->title,'</title>';
    }
  }
?>
