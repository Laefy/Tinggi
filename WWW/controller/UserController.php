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
    $datas = [];

    // Faire les validations //
    $errors = \Accesor::checkPost([
      "login"=>["string"=>["min" => 5, "max" => 30]],
      "email"=>["string"=>["min"=>10, "max" => 50]],
      "password"=>["string"=>["min"=>8, "max" => 50]],
      "verifpassword"=>["comp"=>[\Accesor::post("password", "string")]]
      //Vérification pour l'image de profil à faire
    ]);
    $error = !isempty($errors);
    $datas = $errors;

    // Enregistrer l'utilisateur dans la BDD //
    if(!$error && !\model\User::getByLogin(\Accesor::post("login", "string")) && !\model\User::getByLogin(\Accesor::post("email", "string"))){
      $img = \Accesor::post("img", "file");
      $new_user = new \model\User(\Accesor::post("email", "string"), \Accesor::post("login", "string"), $img, 0);
      $new_user->save();
      $new_user->setPassword(\Session::encrypt(\Accesor::post("password", "string")));

      // Enregistrer l'utilisateur dans la session //
      \Session::signIn($new_user);
    } else {
      $error = true;
      $datas = ["Identifiants déjà utilisés."];
    }

    if(!$error){
      $response = new \view\Response('redirect', '');
      $response->send();
    } else {
      $renderer = new \view\Renderer('Tinggy - Inscription', NULL, $datas);
    }
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
    if(!$error){
      if(\Session::isLogin()){
        $update_user = \Session::getUser();
        $update_user->setLogin(\Accesor::post("login", "string"));
        $update_user->setMail(\Accesor::post("email", "string"));
        $update_user->setImage(\Accesor::post("img", "file"));
        $update_user->update();
        \Session::signIn($update_user);
        $update_user->setPassword(\Session::encrypt(\Accesor::post("password", "string")));
      } else {
        $error = true;
      }
    }

    if(!$error){
      $response = new \view\Response('redirect', '');
      $response->send();
    } else {
      $renderer = new \view\Renderer('Tinggy - Modification', 'profile.view.php', NULL, $errors);
    }
  }
  public function validsignin(){
    $error = false;

    $errors = \Accesor::checkPost([
      "login"=>["string"=>["min" => 5, "max" => 30]],
      "email"=>["string"=>["min"=>10, "max" => 50]],
      "password"=>["string"=>["min"=>8, "max" => 50]],
      "verifpassword"=>["comp"=>[\Accesor::post("password", "string")]]
    ]);

    $error = !isempty($errors);
    if(!$error){
      $id_user = \Database::call("SIGN_IN",[\Accesor::post("login", "string"), \Session::encrypt(\Accesor::post("password", "string"))]);
      $user = \model\User::getById($id_user);
      \Session::signIn($user);
      $errors = ["Identifiants incorrects."];
    }

    if(!$error){
      $response = new \view\Response('redirect', '');
      $response->send();
    } else {
      $renderer = new \view\Renderer('Tinggy - Connexion', 'login.view.php', NULL, $errors);
    }
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
