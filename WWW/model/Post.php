<?php

namespace model;
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

  public function getId(){
    return $this->id;
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

  private static function postFromRow($row) {
    return new Post($row['id'], $row['type'], $row['title'], $row['desc'], $row['time'], User::getById($row['author']), 0, 0);
  }

  public static function getPostById($id){
    $row = \Database::select(['*'], 'post_view', array('id' => $id))[0];
    return postFromRow($row);
  }

  public static function getMatchPosts(){
    $rows = \Database::call('GET_RANDOM_POST', []);
    return array(Post::postFromRow($rows[0]), Post::postFromRow($rows[1]));
  }

  public static function getTopTen(){
    $rows = \Database::select(['*'], 'best_posts', []);
    $posts = array();

    foreach ($rows as $row) {
      array_push(posts, $row);
    }

    return posts;
  }

  public function save(){
    \Database::insert(array('id' => $this->id, 'type' => $this->type, 'title' => '\'' .$this->title. '\'', 'desc' => '\'' .$this->desc. '\'', 'author' => $this->author->getId()), 'post');
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

  public function setAuthor($author){
    $this->author = $author;
  }
}
 ?>
