<?php
class Post {
  private $id;
  private $type;
  private $title;
  private $desc;
  private $time;
  private $author;
  private $comments;
  private $score;
  public function __construct($id, $type, $title, $desc, $time, $author, $comment, $score) {
     $this->id = $id;
     $this->type = $type;
     $this->title = $title;
     $this->desc = $desc;
     $this->time = $time;
     $this->author = $author;
     $this->comments = array();
     $this->score = $score;
  }

  public function getTitle(){
    return $this->title;
  }
  public function getDesc(){
    return $this->desc;
  }
  public function getType(){
    return $this->type;
  }
  public function getTime(){
    return $this->time;
  }
  public function getAuthor(){
    return $this->author;
  }
  public function getComments(){
    return $this->comments;
  }
  public function getScore(){
    return $this->score;
  }
  public static  function  getPostById($id){
    // retourner le post correspondant à l'id
  }

  public static function getMaxId(){
    
    // retourne le post ayant le plus grand id (le dernier post)
  }

  public static function getTopTen(){
    //trié du plus grand score au plus petit score les posts///
    //récuperer les meilleurs qui datent de moins des 30 derniers jours (un mois) /// 
    // retourne les 10 meilleurs posts 
  }

  public function setTitle($title){
    $this->title = $title;
  }

  public function setDesc($desc){
    $this->desc = $desc; 
  }

  public function setType($type){
    $this->type = $type;
  }

  public function setTime($time){
    $this->time = $time;
  }

  public function setAuthor($author){
    $this->author = $author; 
  }


}
 ?>
