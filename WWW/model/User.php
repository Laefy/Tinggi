<?php

namespace model;
class User {
  private $id;
  private $mail;
  private $pseudo;
  private $img;
  private $score;
  private $posts = array();

  public function __construct($mail, $pseudo, $img) {
       $this->id = 0;
       $this->mail = $mail;
       $this->pseudo = $pseudo;
       $this->img = $img;
       $this->score = 0;
  }

  public function getId(){
    return $this->id;
  }

  private static function userFromRow($row) {
    $user = new User($row['mail'], $row['pseudo'], $row['img']);
    $user->id = $row['id'];
    $user->score = $row['score'] == NULL ? 0 : $row['score'];
    return $user;
  }

  public static function getTopTen(){
      $rows = \Database::select(['id', 'mail', 'pseudo', 'img', 'score'], 'best_users', []);
      $users = array();
      foreach ($rows as $row) {
          array_push($users, self::userFromRow($row));
      }
      return $users;
  }

  public static function getById($id){
    $rows = \Database::select(['id', 'mail', 'pseudo', 'img', 'score'], 'user_view', array('id' => $id));
    return count($rows) > 0 ? self::userFromRow($rows[0]) : NULL;
  }

  public static function getByLogin($login) {
    $rows = \Database::select(['id', 'mail', 'pseudo', 'img', 'score'], 'user_view', array('pseudo' => $login));
    return count($rows) > 0 ? self::userFromRow($rows[0]) : NULL;
  }

  public static function getByMail($mail) {
    $rows = \Database::select(['id', 'mail', 'pseudo', 'img', 'score'], 'user_view', array('mail' => $mail));
    return count($rows) > 0 ? self::userFromRow($rows[0]) : NULL;
  }

  public function loadPosts() {
    $this->posts = Post::getPostsByUser($this);
  }

  public function getLogin(){
    return $this->pseudo;
  }

  public function getMail(){
    return $this->mail;
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
    \Database::update(array('password' => $password), 'user', array('pseudo'=> $this->pseudo));
  }

  public function setPosts($posts){
    $this->posts = $posts;
  }

  public function setImage($img){
    $this->img = $img;
  }

  public function setLogin($login){
    $this->pseudo = $login;
  }

  public function setMail($mail){
    $this->mail = $mail;
  }

  public function save() {
    \Database::insert(array('mail' => $this->mail, 'pseudo' => $this->pseudo, 'img' => $this->img), 'user');
  }

  public function update() {
    \Database::update(array('mail' => $this->mail, 'pseudo' => $this->pseudo, 'img' => $this->img), 'user', array('id' => $this->id));
  }

}
?>
