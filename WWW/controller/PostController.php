<?php
namespace controller;

class PostController extends Main{

  public function __construct($title){
      parent::__construct($title);
  }

  static public function instantiate(){
    return new PostController("Post");
  }

  public function render(){
    parent::renderView('post/index');
  }

}
?>
