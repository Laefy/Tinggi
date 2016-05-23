<?php
class User {
  private $id;
  private $mail;
  private $pseudo;
  private $mdp;
  private $img;

  public function __construct($id, $mail, $pseudo, $mdp, $img) {
       $this->id = $id;
       $this->mail = $mail;
       $this->pseudo = $pseudo;
       $this->mdp = $mdp;
       $this->img = $img;
  }

  public function getLogin(){
    return $this->pseudo;
  }
  public function getImage(){
    return $this->img;
  }
}
?>
