<?php
namespace controller;

class UserController extends Controller{

  public function signIn() {
    $data = array();
    $render = new Renderer('Tinggi - Connexion', 'common/login.view.php', $data);
    $render->render();
  }

  public function signOut() {
    \Session::reset();
    $response = new Response('redirect', '');
    $response->send();
  }

  public function signUp() {
    $data = array('user' => NULL);
    $render = new Renderer('Tinggi - Inscription', 'profile.view.php', $data);
    $render->render();
  }

  public function edit() {
    $VIEW_user;
    if(\Session::isLogin()){
      $VIEW_user = \Session::getUser();
    } else {
      $VIEW_user == NULL;
    }
    $data = array('user' => $VIEW_user);
    $render = new Renderer('Tinggi - Modifier votre profile', 'profile.view.php', $data);
    $render->render();
  }

}
?>
