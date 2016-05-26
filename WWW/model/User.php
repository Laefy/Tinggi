<?php

namespace model;
class User {
  private $id;
  private $mail;
  private $pseudo;
  private $img;
  private $score;
  private $posts = array();

  public function __construct($id, $mail, $pseudo, $img, $score) {
       $this->id = $id;
       $this->mail = $mail;
       $this->pseudo = $pseudo;
       $this->img = $img;
       $this->score = $score;
  }

  public function getId(){
    return $this->id;
  }

  private static function userFromRow($row) {
    return new User($row['id'], $row['mail'], $row['pseudo'], $row['img'], $row['score']);
  }

  public static function getTopTen(){
      $rows = \Database::select(['*'], 'best_users', []);
      $users = array();

      foreach ($rows as $row) {
          array_push(users, User::userFromRow($row));
      }

      return users;
  }

  public static function getById($id){
    $row = \Database::select(['id', 'mail', 'pseudo', 'img', 'score'], 'user_view', [])[0];
    return User::userFromRow($row);
  }

  public static function getByLogin($login) {
    $rows = \Database::select(['id', 'mail', 'pseudo', 'img', 'score'], 'user_view', array('login' => $login));
    return count($rows) > 0 ? userFromRow($rows[0]) : NULL;
  }

  public static function getByMail($mail) {
    $rows = \Database::select(['id', 'mail', 'pseudo', 'img', 'score'], 'user_view', array('mail' => $mail));
    return count($rows) > 0 ? userFromRow($rows[0]) : NULL;
  }

  public function loadPosts() {
    $this->posts = Post::getPostsByUser($this);
  }

  public function getLogin(){
    return $this->pseudo;
  }
  public function getPassword(){
    return \Database::select(['password'], 'user', array('id'=>$this->id))[0]['password'];
  }
  public function getImage(){
    return $this->img;
  }

  public function getPosts(){
    return $this->posts;
  }

  public function getScore(){
    return $this->score;
  }

  public function setPassword($password){
    \Database::update(array('password' => '\''.$password.'\''), 'user', array('id'=>$this->id));
  }

  public function setPosts($posts){
    $this->posts = $posts;
  }

  public function setImage($img){
    $this->img = $img;
  }

  public function save() {
    \Database::insert(array('mail' => '\''.$this->mail.'\'', 'pseudo' => '\''.$this->pseudo.'\'', 'img' => $this->img), 'user');
  }

  public function update() {
    \Database::update(array('mail' => '\''.$this->mail.'\'', 'pseudo' => '\''.$this->pseudo.'\'', 'img' => $this->img), 'user', array('id' => $this->id));
  }

}
?>
