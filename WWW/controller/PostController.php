<?php
namespace controller;

class PostController extends Main{

  public function index(){
    $datas = array();

    $nbPost = Post::getMaxId();
    $tmp = rand(1,$nbPost);
    $postLeft = Post::getPostById($nbPost);

    $tmp = rand(1,$nbPost);
    $postRight = Post::getPostById($nbPost);

    $user = Session::getUser();

    array_push($datas, $postleft, $postRight);
    set($datas);

    $this->render('index');
  }
}
?>
