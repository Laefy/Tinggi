<?php
namespace model;

class Comment {
  private $id;
  private $author;
  private $target;
  private $time;
  private $text;
  private $score;

  public function __construct($author,$target,$text){
    $this->id = 0;
    $this->author = $author;
    $this->target = $target;
    $this->time = 0;
    $this->text = $text;
    $this->score = 0;
  }

  private static function commentFromRow($row) {
    $comment = new Comment(User::getById($row['author']), NULL, $row['texte']);
    $comment->id = $row['id'];
    $comment->time = $row['time'];
    $comment->score = $row['score'];
    return $comment;
  }

  public static function getCommentsByPost($post) {
      $rows = \Database::select(['*'], 'comment_view', array('target' => $post->getId()));
      $comments = array();

      foreach ($rows as $row) {
        $comment = self::commentFromRow($row);
        $comment->target = $post;
        array_push($comments, $comment);
      }

      return $comments;
  }


  public function getText(){
    return $this->text;
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
    Database::insert(array('author' => $this->author->getId(), 'target' => $this->target->getId(), 'texte' => $this->text),'comment');
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

  public function delete() {
    \Database::delete($this->id, 'comment');
  }
}
?>
