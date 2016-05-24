<?php
class User {
  private $id;
  private $mail;
  private $pseudo;
  private $img;
  private $score;

  public function __construct($id, $mail, $pseudo, $mdp, $img) {
       $this->id = $id;
       $this->mail = $mail;
       $this->pseudo = $pseudo;
       $this->img = $img;
  }

  public function getLogin(){
    return $this->pseudo;
  }
  public function getMDP(){
    //Récupère le mot de passe de la BDD
  }
  public function getImage(){
    return $this->img;
  }

  public function getScore(){
    return $this->score;
  }
  public function setScore(){
    //Fait la somme des scores des posts de l'utilisateur
  }
}
?>
