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

  public function top() {
    if(!\Session::isLogin()){
      $response = new \view\Response('redirect', 'signin');
      $response->send();
    }
    $VIEW_user = \Session::getUser();
    $VIEW_topusers = \model\User::getTopTen();
    $VIEW_posts = \model\Post::getPostsByUser($VIEW_user);
    $render = new \view\Renderer('Tinggy - Les Tops des Tops', 'tops.view.php', $VIEW_user,['users' => $VIEW_topusers, 'posts' => $VIEW_posts]);
    $render->render();
  }

  public function validsignup(){
    $error = false;

    // Faire les validations //
    $errors = \Accesor::checkPost([
      "login"=>["string"=>["min" => 5, "max" => 30]],
      "email"=>["string"=>["min"=>10, "max" => 50]],
      "password"=>["string"=>["min"=>8, "max" => 50]],
      "verifpassword"=>["comp"=>[\Accesor::post("password", "string")]]
      //Vérification pour l'image de profil à faire
    ]);
    $error = !empty($errors);

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
      array_push($errors, "Login ou adresse mail déjà utilisé.");
    }

    if(!$error){
      $response = new \view\Response('redirect', '');
      $response->send();
    } else {
      $datas = array(
        "error" => $error,
        "errors" => $errors
      );
      $renderer = new \view\Renderer('Tinggy - Inscription',"profile.view.php", NULL, $datas);
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
    $error = !empty($errors);

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
      $VIEW_user = \Session::getUser();
      $datas = array(
        "error" => $error,
        "erreors" => $errors
      );
      $renderer = new \view\Renderer('Tinggy - Modification', 'profile.view.php', $VIEW_user, $datas);
    }
  }

  public function validsignin(){
    $error = false;

    $errors = \Accesor::checkPost([
      "login"=>["string"=>["min" => 5, "max" => 30]],
      "password"=>["string"=>["min"=>8, "max" => 50]]
    ]);

    $error = !empty($errors);
    if(!$error){
    $id_user = \Database::call("SIGN_IN",[\Accesor::post("login", "string"), \Session::encrypt(\Accesor::post("password", "string"))]);

      if(empty($id_user)){
        array_push($errors,["Identifiants incorrects."]);
        $error = true;
      }
    }

    if(!$error){
      $user = \model\User::getById($id_user);
      \Session::signIn($user);

      $response = new \view\Response('redirect', '');
      $response->send(NULL);
    } else {

      $datas = array(
        "error" => $error,
        "errors" => $errors
      );
      $render = new \view\Renderer('Tinggy - Connexion', 'login.view.php', NULL, $datas);
      $render->render();
    }
  }

  public function tops(){
    $VIEW_user;
    if(\Session::isLogin()){
      $VIEW_user = \Session::getUser();
    } else {
      $VIEW_user = NULL;
    }

    $data = array('user' => $VIEW_user);
    $render = new \view\Renderer('Tinggy - Top du top', 'tops.view.php', $data);
    $render->render();
  }
}
?>
