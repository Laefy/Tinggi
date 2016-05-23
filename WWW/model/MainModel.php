<?php
  class Tinggi{

    private $title;
    private $icon;
    private $dir;
    private $enconding;
    private $style;

    public function __construct($dir, $title){
      $this->dir = $dir;
      $this->title = $title;
      $this->encoding = "UTF-8";
      $this->icon = "tinggi.png";
      $this->style = "main.css";
    }

    public function buildHeader(){
        echo
        '<link rel="stylesheet" href="',$this->dir,'/css/',$this->style,'/>
        <link rel="icon" type="image/x-png" href="',$this->dir,'/data/img/',$this->icon,'" />
        <meta charset="$this->encoding"/>
        <title>',$this->title,'</title>';
    }

  }
 ?>
