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
      $VIEW_user = NULL;
    }

    $VIEW_posts = \model\Post::getTopTen();
    $data = array(
        "posts" => $VIEW_posts
      );
    $render = new \view\Renderer('Tinggy - Top', 'top.view.php', $VIEW_user, $data);
    $render->render();
  }

  public function read($id) {
    $VIEW_user;
    if(\Session::isLogin()){
      $VIEW_user = \Session::getUser();
    } else {
      $VIEW_user = NULL;
    }

    $VIEW_post = \model\Post::getPostById($id);

    $data = array(
      'post' => $VIEW_post
    );

    $data = \model\Post::getPostById($id);
    $data->loadComments();

    $render = new \view\Renderer('Tinggy - '.$VIEW_post->getTitle(), 'read.view.php', $VIEW_user, $data);
    $render->render();
  }

  public function create() {
    $VIEW_user;
    if(\Session::isLogin()){
      $VIEW_user = \Session::getUser();
    } else {
      $VIEW_user = NULL;
    }

    if($VIEW_user){
      $render = new \view\Renderer('Tinggy - Nouveau poste', 'create.view.php', $VIEW_user, NULL);
      $render->render();
    } else {
      $response = new \view\Response('redirect', 'signup');
      $response->send(NULL);
    }
  }

  public function match(){
      $matches = \model\Post::getMatchPosts();
      $m1 = $matches[0];
      $m2 = $matches[1];
      $response = new \view\Response('json', NULL, array("id1" => $m1->getId(), "title1" => $m1->getTitle(), "description1" => PostController::baliseFromDescription($m1->getDesc()), "id2" => $m2->getId(), "title2" => $m2->getTitle(), "description2" => PostController::baliseFromDescription($m1->getDesc())));
      $response->send('');
  }

  public function winner($postID) {
    echo "Winner is " . $postID;
  }

  public function like($postID){
    $post = \model\Post::getPostById($postID);
    $post->toggleLike();

    $response = new \view\Response("json",NULL,["user"=>$post->getUserScore(), "global" => $post->getScore()]);
    $response->send(NULL);
  }

  public function dislike($postID){
    $post = \model\Post::getPostById($postID);
    $post->toggleDislike();
  }

  static function parseDescription($desc,$url){
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
    $error = false;

    // Faire les validations
    $errors = \Accesor::checkPost([
      "title"=>["string"=>["min" => 1, "max" => 100]],
      "url"=>["string"=>["min"=>1, "max" => 100]],
      "description"=>["string"=>["min"=>1]],
    ]);
    $error = !empty($errors);

    if(!$error){
      $post = new \model\Post(\Accesor::post('title','string'),
                              self::parseDescription(\Accesor::post('description','string'),
                              \Accesor::post('url','string')),
                              \model\User::getById(1));
      print_r($post);
      $post->save();
      $response = new \view\Response('redirect', 'match');
    } else {
      $response = new \view\Response('redirect', 'signup');
    }
    //$response = new \view\Response("json",NULL,["user"=>$post->getUserScore(), "global" => $post->getScore()]);
    $response->send(NULL);
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
          return '<img class="img_match" src="' .\Router::$ROOT. 'data/img/' .$matches['mediaContent']. '">';
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
