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
    $comment = new Comment(0,$VIEW_user.getId(),$id,0,$_POST['comment'],0);
    $coment->save();
    
    $response = new Response('redirect', 'post/'.$id);
    $response->send();
  }

}
?>
