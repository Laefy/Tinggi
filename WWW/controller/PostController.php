<?php
use view\Response as Response;
namespace controller;

class PostController extends Controller{

  public function index() {
    $VIEW_user = "";

    if(\Session::isLogin()){
      $VIEW_user = \Session::getUser();
    } else {
      $VIEW_user = NULL;
    }

    $VIEW_posts = \model\Post::getMatchPosts();

    $data = array(
        "user" => $VIEW_user,
        "posts" => $VIEW_posts,
      );
    $render = new \view\Renderer('Tinggi - Match', 'match.view.php', $data);
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

    $data = array(
      'user' => $VIEW_user,
      'post' => $VIEW_post
    );

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

    $data = array(
      'user' => $VIEW_user
    );
    $render = new Renderer('Tinggi - Nouveau poste', 'create.view.php', $data);
    $render->render();
  }

}
?>
