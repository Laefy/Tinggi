<?php
class Post {
  private $id;
  private $type;
  private $title;
  private $desc;
  private $time;
  private $author;
  private $comments;

  public function __construct($id, $type, $title, $desc, $time, $author) {
     $this->id = $id;
     $this->type = $type;
     $this->title = $title;
     $this->desc = $desc;
     $this->time = $time;
     $this->author = $author;
     $this->comments = array();
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
}
 ?>
