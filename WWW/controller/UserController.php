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
    $render = new \view\Renderer('Tinggy - Inscription', 'profile.view.php',['title' => 'Hey !', 'description' => 'rejoins nous on a des "cookies" !', 'action' => 'Créer', 'check' => 'signup/new']);
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
    $render = new \view\Renderer('Tinggy - Modifier votre profile', 'profile.view.php',['title' => 'Votre profile', 'description' => 'il est cool non ?', 'action' => 'Mettre à jour', 'check' => 'user/'.\Session::getUser()->getLogin().'/update']);
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
    ]);

    if(!\Session::isNotARobot()){
        array_push($errors,"Vous êtes un robot ! :/");
    }

    $img = \Accessor::post("img", "file");
    if($img=='') {
      $img = 'default.png';
    } else {
      $fileerror = \Accessor::checkFile("img", ["maxsize" => 1000000, "resolution" => 500]);
      if($fileerror)
        array_push($errors,$fileerror);
    }

    $error = !empty($errors);

    if(!$error)
    {
      // Enregistrer l'utilisateur dans la BDD //
      if($img!='default.png'){
        $img = uniqid().'.'.pathinfo($_FILES["img"]['name'], PATHINFO_EXTENSION);
        \Accessor::saveFile($_FILES['img']['tmp_name'], $img);
      }
      $new_user = new \model\User(\Accessor::post("email", "string"), \Accessor::post("login", "string"),$img, 0);
      $new_user->save();
      $new_user->setPassword(\Session::encrypt(\Accessor::post("password", "string")));
      var_dump(\model\User::getByLogin($new_user->getLogin()));
      // Enregistrer l'utilisateur dans la session //
      \Session::signIn($new_user);
      $response = new \view\Response('redirect', '');
      $response->send();
    }
    $datas = array("error" => $error, "errors" => $errors, 'title' => 'Hey !', 'description' => 'rejoins nous on a des "cookies" !', 'action' => 'Créer', 'check' => 'signup/new');
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
    $update_user = \Session::getUser();

    $img = \Accessor::post("img", "file");
    if($img=='') {
      $img = $update_user->getImage();
    } else {
      $fileerror = \Accessor::checkFile("img", ["maxsize" => 1000000, "resolution" => 500]);
      if($fileerror)
        array_push($errors,$fileerror);
    }

    $error = !empty($errors);

    // Faire les validations
    if(!$error){
      $update_user->setLogin(\Accessor::post("login", "string"));
      $update_user->setMail(\Accessor::post("email", "string"));
      $update_user->setImage($img);
      $error = $update_user->update();
      if(!$error)
      {
        \Session::signIn($update_user);
        $update_user->setPassword(\Session::encrypt(\Accessor::post("password", "string")));
        $response = new \view\Response('redirect', '');
        $response->send();
      }
    }
    $renderer = new \view\Renderer('Tinggy - Modification', 'profile.view.php', ["error" => $error, "errors" => $errors,'title' => 'Votre profile', 'description' => 'il est cool non ?', 'action' => 'Mettre à jour', 'check' => 'user/'.\Session::getUser()->getLogin().'/update']);
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
}
?>
