<?php
namespace model;

class Comment {
  private $id;
  private $author;
  private $target;
  private $time;
  private $text;
  private $score;

  public function __construct($id,$author,$target,$time,$text,$score){
    $this->id = $id;
    $this->author = $author;
    $this->target = $target;
    $this->time = $time;
    $this->text = $text;
    $this->score = $score;
  }

  private static function commentFromRow($row) {
    return new Comment($row['id'], User::getById($row['author']), NULL, $row['time'], $row['text'], $row['score']);
  }

  public static function getCommentsByPost($post) {
      $rows = \Database::select(['*'], 'comment', array('target' => $post->getId()));
      $comments = array();

      foreach ($rows as $row) {
        $comment = commentFromRow($row);
        $comment->target = $post;
        array_push($comments, $comment);
      }

      return $comments;
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

  public function save(){
    Database::insert(array('id' => $this->id, 'author' => $this->author->getId(), 'target' => $this->target->getId(), 'texte' => '\'' .$this->text. '\''),'comment');
  }

  public function setDesc($desc){
    $this->desc = $desc;
  }

  public function setText($text){
    $this->text=$text;
  }

  public function setAuthor($author){
    $this->author = $author;
  }

  public function setScore($score){
    $this->score = $score;
  }
}
?>
