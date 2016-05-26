<?php
use \view\Response as Response;
use \view\Renderer as Renderer;
namespace controller;

class PostController extends Controller{

  public function index() {
    $VIEW_user = "";

    if(\Session::isLogin()){
      $VIEW_user = \Session::getUser();
    } else {
      $VIEW_user = NULL;
    }
    $VIEW_posts;
    $session_Match = \Session::getMatch();
    if($session_Match == NULL){
      $VIEW_posts = \model\Post::getMatchPosts();
    } else {
      array_push($VIEW_posts, \model\Post::getPostById($session_Match[0]), \model\Post::getPostById($session_Match[1]));
    }

    $data = array(
        "post1" => $VIEW_posts[0],
        "post2" => $VIEW_posts[1]
                  );
    $render = new \view\Renderer('Tinggy - Match', 'match.view.php',$VIEW_user, $data);
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
        "posts" => $VIEW_posts
      );
    $render = new Renderer('Tinggy - Top', 'top.view.php', $VIEW_user, $data);
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
      'post' => $VIEW_post
    );

    $render = new Renderer('Tinggy - '.$VIEW_post->getTitle(), 'read.view.php', $VIEW_user, $data);
    $render->render();
  }

  public function create() {
    $VIEW_user;
    if(\Session::isLogin()){
      $VIEW_user = \Session::getUser();
    } else {
      $VIEW_user == NULL;
    }

    $data = array();
    $render = new Renderer('Tinggy - Nouveau poste', 'create.view.php', $VIEW_user, $data);
    $render->render();
  }

  public function match($postID){

  }

  public function like($postID){
    $post = \model\Post::getPostById($postID);
    $post->toggleLike();

    echo '{ "user":' . $post->getUserScore() . ', "global":' . $post->getScore() . ' }';
  }

  public function dislike($postID){
    $post = \model\Post::getPostById($postID);
    $post->toggleDislike();

    echo '{ "user":' . $post->getUserScore() . ', "global":' . $post->getScore() . ' }';
  }

  public static function getPostDescPattern(){
    return '/^((?P<mediaType>\w+):\s*(?P<mediaContent>\d+)\n)?(?P<postDesc>.*)/';
  }

  public static function makeBaliseFromDesc($desc){
    if(preg_match(self::getPostDescPattern(),$desc, $matches)){
      print_r($matches);
      /*switch ($matches) {
        case 'value':
          # code...
          break;

        default:
          # code...
          break;
      }*/
    }
    else{
      echo 'Contenu indisponible';
    }
  }

}
?>
