<?php
use view\Response as Response;
namespace controller;

class PostController extends Controller{

  public function index() {
    $VIEW_user = "";

    if(\Session::isLogin()){
      $VIEW_user = \Session::getUser();
    } else {
      $VIEW_user == NULL;
    }

    $nbPost = \model\Post::getMaxId();
    $postLeft = rand(1,$nbPost);
    $postRight = 0;
    do{
      $postRight = rand(1,$nbPost);
    }while($postLeft == $postRight);

    $VIEW_postLeft = \model\Post::getPostById($postLeft);
    $VIEW_postRight = \model\Post::getPostById($postRight);

    $data = array(
        "user" => $VIEW_user,
        "postLeft" => $VIEW_postLeft,
        "postfRight" => $VIEW_postRight
      );
    $render = new Renderer('Tinggi - Match', 'match.view.php', $data);
    $render->render();
  }

  public function top() {
    $VIEW_user;
    if(\Session::isLogin()){
      $VIEW_user = \Session::getUser();
    } else {
      $VIEW_user == NULL;
    }

    $VIEW_posts = \model\Post::getTopTen();
    $data = array(
        "user" => $VIEW_user,
        "posts" => $VIEW_posts
      );
    $render = new Renderer('Tinggi - Top', 'top.view.php', $data);
    $render->render();
  }

  public function read($id) {
    $VIEW_user;
    if(\Session::isLogin()){
      $VIEW_user = \Session::getUser();
    } else {
      $VIEW_user == NULL;
    }

    $VIEW_post = \model\Post::getPostById($id);

    $render = new Renderer('Tinggi - '.$VIEW_post->getTitle(), 'read.view.php', $data);
    $render->render();
  }

  public function create() {
    $VIEW_user;
    if(\Session::isLogin()){
      $VIEW_user = \Session::getUser();
    } else {
      $VIEW_user == NULL;
    }

    $render = new Renderer('Tinggi - Nouveau poste', 'create.view.php');
    $render->render();
  }

}
?>
