<?php
namespace controller;

class UserController extends Controller{

  public function signIn() {
    $render = new Renderer('Tinggi - Connexion', 'common/login.view.php');
    $render->render();
  }

  public function signOut() {
    \Session::destroy();
    $response = new Response('redirect', '');
    $response->send();
  }

  public function signUp() {
    $VIEW_user == NULL;
    $render = new Renderer('Tinggi - Inscription', 'profile.view.php');
    $render->render();
  }

  public function edit() {
    $VIEW_user;
    if(\Session::isLogin()){
      $VIEW_user = \Session::getUser();
    } else {
      $VIEW_user == NULL;
    }

    $render = new Renderer('Tinggi - Modifier votre profile', 'profile.view.php');
    $render->render();
  }

}
?>
