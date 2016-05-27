<?php
use \view\Response as Response;
use \view\Renderer as Renderer;
namespace controller;

class PostController extends Controller{

  public function index() {
    $posts = [];
    $match1 = \Session::getVar('match1');
    $match2 = \Session::getVar('match2');
    if(($match1) && ($match2)){
      array_push($posts, \model\Post::getPostById($match1), \model\Post::getPostById($match2));
    }
    else{
      $posts = \model\Post::getMatchPosts();
    }
    $renderer = new \view\Renderer('Tinggy - Juste du rire', 'match.view.php', ["post1" => $posts[0],"post2" => $posts[1]]);
    $renderer->render();
  }

  public function top() {
    $renderer = new \view\Renderer('Tinggy - Top des publications', 'top.view.php', ["posts" => \model\Post::getTopTen()]);
    $renderer->render();
  }

  public function read($id) {
    $post = \model\Post::getPostById($id);
    $post->loadComments();
    $comments = $post->getComments();
    $renderer = new \view\Renderer('Tinggy - '.$post->getTitle(), 'read.view.php', ['post' => $post, 'comments' => $comments]);
    $renderer->render();
  }

  public function create() {
    if(!\Session::isLogin()) {
      $response = new \view\Response('redirect', 'signup');
      $response->send();
    }
    $render = new \view\Renderer('Tinggy - Nouvelle publication', 'create.view.php');
    $render->render();
  }

  public function match(){
      $matches = \model\Post::getMatchPosts();
      $m1 = $matches[0];
      $m2 = $matches[1];
      $response = new \view\Response('json', NULL, array("id1" => $m1->getId(), "title1" => $m1->getTitle(), "description1" => PostController::baliseFromDescription($m1->getDesc()), "id2" => $m2->getId(), "title2" => $m2->getTitle(), "description2" => PostController::baliseFromDescription($m1->getDesc())));
      $response->send();
  }

  public function winner($postID) {
    echo "Winner is " . $postID;
  }

  public function like($postID){
    $post = \model\Post::getPostById($postID);
    $post->toggleLike();
    $response = new \view\Response("json",NULL,["user"=>$post->getUserScore(), "global" => $post->getScore()]);
    $response->send();
  }

  public function dislike($postID){
    $post = \model\Post::getPostById($postID);
    $post->toggleDislike();
    $response = new \view\Response("json",NULL,["user"=>$post->getUserScore(), "global" => $post->getScore()]);
    $response->send();
  }

  public static function parseDescription($desc,$url){
    if(preg_match('/\.(jpg|png|gif|ppm)$/i',$url)){
      return 'img:'.$url.'\n'.$desc;
    }
    else if(preg_match('/^(http|https):\/\/(www\.)?(youtube.com|vimeo.com)\/.*/i',$url)){
      return 'vid:'.$url.'\n'.$desc;
    }
    else{
      return $desc;
    }
  }

  public function send(){
    if(!\Session::isLogin()){
      $response = new \view\Response('redirect', 'signin');
      $response->send();
    }

    // Faire les validations
    $errors = \Accessor::checkPost([
      "title"=>["string"=>["min" => 1, "max" => 100]],
      "description"=>["string"=>["min"=>1]],
    ]);

    $error = !empty($errors);

    if(!$error){
      $post = new \model\Post(\Accessor::post('title','string'),self::parseDescription(\Accessor::post('description','string'),\Accessor::post('url','string')),\Session::getUser());
      $post->save();
      $response = new \view\Response('redirect', 'match');
      $response->send();
    }
    $renderer = new \view\Renderer('Tinggy - Nouvelle publication', 'create.view.php',['error' => $error, 'errors' => $errors]);
    $renderer->render();
  }


  public static function getPostDescPattern(){
    return '/^((?P<mediaType>\w+):\s*(?P<mediaContent>[a-zA-Z0-9\/\_\.:=\?]+)\s)?(?P<postDesc>.*)/';
  }

  public static function makeBaliseFromDesc($desc){
    echo PostController::baliseFromDescription($desc);
  }

  private static function baliseFromDescription($description) {
    if(preg_match(self::getPostDescPattern(),$description, $matches)){
      switch ($matches['mediaType']) {
        case 'img':
          return '<img class="img_match" src="'.$matches['mediaContent'].'">';
        case 'vid':
            return '<iframe src="' .str_replace('watch?v=','embed/',$matches['mediaContent']). '" frameborder="0" allowfullscreen></iframe>';
        default:
            return $matches['postDesc'];
      }
    }
    else{
      return 'Contenu indisponible';
    }
  }

}
?>
