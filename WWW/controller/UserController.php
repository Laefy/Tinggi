<?php
use \view\Response as Response;
use \view\Renderer as Renderer;
namespace controller;

class UserController extends Controller{

  public function signIn() {
    if(\Session::isLogin()){
      $response = new \view\Response('redirect', '');
      $response->send();
    }
    $render = new \view\Renderer('Tinggy - Connexion', 'login.view.php');
    $render->render();
  }

  public function signOut() {
    \Session::reset();
    $response = new \view\Response('redirect', '');
    $response->send();
  }

  public function signUp() {
    $render = new \view\Renderer('Tinggy - Inscription', 'profile.view.php',['title' => 'Hey !', 'description' => 'rejoins-nous on a des "cookies" !', 'action' => 'Créer', 'check' => 'signup/new']);
    $render->render();
  }

  public function edit() {
    if(!\Session::isLogin()){
      $response = new \view\Response('redirect', 'signin');
      $response->send();
    }
    if((!isset($_POST['login']))&&(!isset($_POST['email'])))
    {
      $_POST['login'] = \Session::getUser()->getLogin();
      $_POST['email'] = \Session::getUser()->getMail();
    }
    $render = new \view\Renderer('Tinggy - Modifier votre profile', 'profile.view.php',['title' => 'Votre profil', 'description' => 'il est cool non ?', 'action' => 'Mettre à jour', 'check' => 'user/'.\Session::getUser()->getLogin().'/update']);
    $render->render();
  }

  public function board() {
    if(!\Session::isLogin()){
      $response = new \view\Response('redirect', 'signin');
      $response->send();
    }
    $renderer = new \view\Renderer('Tinggy - Les Tops des Tops', 'board.view.php',['users' => \model\User::getTopTen(), 'posts' => \model\Post::getPostsByUser(\Session::getUser())]);
    $renderer->render();
  }

  public function validsignup(){
    // Faire les validations //
    $errors = \Accessor::checkPost([
      "login"=>["string"=>["min" => 5, "max" => 30]],
      "email"=>["string"=>["min"=>10, "max" => 50]],
      "password"=>["string"=>["min"=>8, "max" => 50]],
      "verifpassword"=>["comp"=>[\Accessor::post("password", "string")]]
      //Vérification pour l'image de profil à faire
    ]);

    if(!\Session::isNotARobot()){
        array_push($errors,"Vous êtes un robot ! :/");
    }

    if(empty($errors)) {
      $img = \Accessor::post("img", "file");
      if(!$img) {
        $img = 'default.png';
      }

      $mail = \Accessor::post("email", "string");
      $login = \Accessor::post("login", "string");

      // Check that the user is not already in the database.
      if (\model\User::getByLogin($login) != NULL) {
          echo 'prout';
          array_push($errors, "Le login est déjà utilisé.");
      }

      if (\model\User::getByMail($mail) != NULL) {
          array_push($errors, "L'adresse mail est déjà utilisée.");
      }

      if (empty($errors)) {
        $new_user = new \model\User($mail, $login, $img);
        $new_user->save();
        $new_user->setPassword(\Session::encrypt(\Accessor::post("password", "string")));
    //    var_dump(\model\User::getByLogin($new_user->getLogin()));
    //    exit();

        // Enregistrer l'utilisateur dans la session //
        \Session::signIn(\model\User::getByLogin($new_user->getLogin()));
        $response = new \view\Response('redirect', '');
        $response->send();
      }
    }

    $datas = array("error" => !empty($errors), "errors" => $errors, 'title' => 'Hey !', 'description' => 'rejoins-nous on a des "cookies" !', 'action' => 'Créer', 'check' => 'signup/new');
    $renderer = new \view\Renderer('Tinggy - Inscription',"profile.view.php", $datas);
    $renderer->render();
  }

  public function validmodif($login){
    //utilisateur non logé ou different
    if((!\Session::isLogin())||(strcmp(\Session::getUser()->getLogin(),$login) != 0)){
      $response = new \view\Response('redirect', 'signin');
      $response->send();
    }

    if(!\Session::isNotARobot()){
        array_push($errors,"Vous êtes un robot ! :/");
    }

    // Faire les validations //
    $errors = \Accessor::checkPost([
      "login"=>["string"=>["min" => 5, "max" => 30]],
      "email"=>["string"=>["min"=>10, "max" => 50]],
      "password"=>["string"=>["min"=>8, "max" => 50]],
      "verifpassword"=>["comp"=>[\Accessor::post("password", "string")]]
      //Vérification pour l'image de profil à faire
    ]);
    $error = !empty($errors);

    // Faire les validations
    if(!$error){
      $update_user = \Session::getUser();
      $update_user->setLogin(\Accessor::post("login", "string"));
      $update_user->setMail(\Accessor::post("email", "string"));
      $update_user->setImage(\Accessor::post("img", "file"));
      $error = $update_user->update();
      if(!$error)
      {
        \Session::signIn($update_user);
        $update_user->setPassword(\Session::encrypt(\Accessor::post("password", "string")));
        $response = new \view\Response('redirect', '');
        $response->send();
      }
    }
    $renderer = new \view\Renderer('Tinggy - Modification', 'profile.view.php', ["error" => $error, "errors" => $errors,'title' => 'Votre profil', 'description' => 'il est cool non ?', 'action' => 'Mettre à jour', 'check' => 'user/'.\Session::getUser()->getLogin().'/update']);
    $renderer->render();
  }

  public function validsignin(){
    $errors = \Accessor::checkPost([
      "login"=>["string"=>["min" => 5, "max" => 30]],
      "password"=>["string"=>["min"=>8, "max" => 50]]
    ]);

    if(!\Session::isNotARobot()){
        array_push($errors,"Vous êtes un robot ! :/");
    }

    $error = !empty($errors);

    if(!$error)
    {
      $id_user = \Database::call_function("SIGN_IN",[\Accessor::post("login", "string"), \Session::encrypt(\Accessor::post("password", "string"))]);
      if($id_user == 0){
        array_push($errors,"Identifiants incorrects.");
        $error = true;
      }
      else
      {
        $user = \model\User::getById($id_user);
        \Session::signIn($user);
        $response = new \view\Response('redirect', '');
        $response->send();
      }
    }
    $renderer = new \view\Renderer('Tinggy - Connexion', 'login.view.php', ["error" => $error,"errors" => $errors]);
    $renderer->render();
  }

  public function tops(){
    $render = new \view\Renderer('Tinggy - Top du top', 'tops.view.php');
    $render->render();
  }

  public static function getLogo() {
    $user = \Session::getUser();
    if ($user == NULL) {
      return 'logo';
    } else if ($user->getScore() < 5) {
      return 'md-1';
    } else if ($user->getScore() < 20) {
      return 'md-2';
    } else if ($user->getScore() < 50) {
      return 'md-3';
    } else if ($user->getScore() < 100) {
      return 'md-4';
    } else if ($user->getScore() < 1000) {
      return 'md-5';
    } else {
      return 'md-6';
    }
  }
}
?>
