<?php
use \view\Response as Response;
use \view\Renderer as Renderer;
namespace controller;

class UserController extends Controller{

  public function signIn() {
    $render = new \view\Renderer('Tinggy - Connexion', 'login.view.php', NULL, NULL);
    $render->render();
  }

  public function signOut() {
    \Session::reset();
    $response = new \view\Response('redirect', '');
    $response->send();
  }

  public function signUp() {
    $render = new \view\Renderer('Tinggy - Inscription', 'profile.view.php', NULL, NULL);
    $render->render();
  }

  public function edit() {
    $VIEW_user;
    if(\Session::isLogin()){
      $VIEW_user = \Session::getUser();
    } else {
      $VIEW_user == NULL;
    }

    $render = new \view\Renderer('Tinggy - Modifier votre profile', 'profile.view.php', $VIEW_user, NULL);
    $render->render();
  }
  public function validsignup(){
    $error = false;

    // Faire les validations
    $errors = \Accesor::checkPost([
      "login"=>["string"=>["min" => 5, "max" => 30]],
      "email"=>["string"=>["min"=>10, "max" => 50]],
      "password"=>["string"=>["min"=>8, "max" => 50]],
      "verifpassword"=>["comp"=>[\Accesor::post("password", "string")]]
    ]);
    $error = !isempty($errors);

    // Enregistrer l'utilisateur dans la BDD

    // Enregistrer l'utilisateur dans la session

    if($error){
      $response = new \view\Response('redirect', '');
    } else {
      $response = new \view\Response('redirect', 'signup');
    }
    $response->send();
  }
  public function validmodif($id){
    $error = false;

    $errors = \Accesor::checkPost([
      "login"=>["string"=>["min" => 5, "max" => 30]],
      "email"=>["string"=>["min"=>10, "max" => 50]],
      "password"=>["string"=>["min"=>8, "max" => 50]],
      "verifpassword"=>["comp"=>[\Accesor::post("password", "string")]]
    ]);
    $error = !isempty($errors);

    // Faire les validations

    // Enregistrer l'utilisateur dans la session

    // Enregistrer l'utilisateur dans la BDD

    if($error){
      $response = new \view\Response('redirect', '');
    } else {
      $response = new \view\Response('redirect', 'user/'.(\Session::getUser().getLogin()));
    }
    $response->send();
  }
  public function validsignin(){
    $error = false;

    extract($_POST);

    // Faire les validations

    // Enregistrer l'utilisateur dans la session

    if($error){
      $response = new \view\Response('redirect', '');
    } else {
      $response = new \view\Response('redirect', 'erreur');
    }
    $response->send();
  }

  public function tops(){
    $VIEW_user;
    if(\Session::isLogin()){
      $VIEW_user = \Session::getUser();
    } else {
      $VIEW_user == NULL;
    }

    $data = array('user' => $VIEW_user);
    $render = new \view\Renderer('Tinggy - Top du top', 'tops.view.php', $data);
    $render->render();
  }
}
?>
