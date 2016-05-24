<?php
class Comment {
  private $id;
  private $author;
  private $time;
  private $text;
  private $score;

  public function __construct($id,$author,$target,$time,$text,$score){
    $this->id = $id;
    $this->$author = $author;
    $this->$time = $time;
    $this->$text = $text;
    $this->$score = $score;
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

  public function getScore(){
    return $this->score;
  }


  public function setDesc($desc){
    this->$desc = $desc;
  }

  public function setTime($time){
    this->$time = $time;
  }

  public function setText($text){
    this->$text=$text;
  }

  public function setAuthor($author){
    this->$author = $author; 
  }

  public function setScore($score){
    this->$score = $score;
  }

}
?>
