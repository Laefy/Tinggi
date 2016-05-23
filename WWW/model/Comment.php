<?php
class Comment {
  private $id;
  private $author;
  private $target;
  private $time;
  private $text;

  public function __construct($id,$author,$target,$time,$text){
    $this->id = $id;
    $this->$author = $author;
    $this->$target = $target;
    $this->$time = $time;
    $this->$text = $text;
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
}
?>
