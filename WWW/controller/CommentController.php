<?php
namespace controller;

class CommentController extends Controller{

  public function send($id) {
    $VIEW_user;
    if(\Session::isLogin()){
      $VIEW_user = \Session::getUser();
    } else {
      $VIEW_user == NULL;
    }
    $comment = new Comment($VIEW_user,\model\Post::getById($id),$_POST['comment']);
    $comment->save();
    
    $response = new Response('redirect', 'post/'.$id);
    $response->send();
  }

}
?>
