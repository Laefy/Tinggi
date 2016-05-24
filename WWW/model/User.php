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

  public function getLogin(){
    return $this->pseudo;
  }
  public function getPassword(){
    //retourne le mot de passe de la BDD
  }
  public function getImage(){
    return $this->img;
  }

  public function getPosts(){
    //retourne les posts de l'utilisateur (grâçe à un id)
  }

  public function getScore(){
    return $this->score;
  }

  public function setPassword(){
    //enregistre le mot de passe de l'utilisateur
  }

  public function setScore(){
    //Fait la somme des scores des posts de l'utilisateur
  }

  public function setPosts(){
    //enregistre les posts de l'utilisateur (grâçe a son id )
  }

  public function setImage(){
    //enregistre une chaine de caractère (qui redirige vers une image)
  }

}
?>
