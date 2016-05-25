<?php
class User {
  private $id;
  private $mail;
  private $pseudo;
  private $img;
  private $score;
  private $posts = array();

  public function __construct($id, $mail, $pseudo, $mdp, $img) {
       $this->id = $id;
       $this->mail = $mail;
       $this->pseudo = $pseudo;
       $this->img = $img;
  }

  public function getId(){
    return $this->id;
  }

  public static function getById($id){
    Database::select(['id', 'mail', 'pseudo', 'img', 'score'], 'user', '')
  }

  public function getLogin(){
    return $this->pseudo;
  }
  public function getPassword(){
    return Database::select(['password'], 'user', array('id'=>$this->id))[0]['password'];
  }
  public function getImage(){
    return $this->img;
  }

  public function getPosts(){
    return $this->posts;
  }

  public function getScore(){
    return $this->score;
  }

  public function setPassword($password){
    Database::update(array('password' => '\''.$password.'\''), 'user', array('id'=>$this->id));
  }

  public function setPosts($posts){
    $this->posts = $posts;
  }

  public function setImage($img){
    $this->img = $img;
  }

}
?>
