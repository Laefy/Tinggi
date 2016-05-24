<?php
namespace model;

  class Main{

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

  }
 ?>
