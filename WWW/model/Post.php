<?php

namespace model;
class Post {
    private $id;
    private $title;
    private $desc;
    private $time;
    private $author;
    private $comments;
    private $score;
    private $userScore;

    public function __construct($id, $title, $desc, $time, $author, $comment, $score) {
         $this->id = $id;
         $this->title = $title;
         $this->desc = $desc;
         $this->time = $time;
         $this->author = $author;
         $this->comments = array();
         $this->score = $score;
         $this->userScore = 0;
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

    public function getUserScore() {
        return $this->userScore;
    }

    private static function postFromRow($row) {
        return new Post($row['id'], $row['title'], $row['description'], $row['time'], User::getById($row['author']), 0, $row['score']);
    }

    public static function getPostById($id){
        return Post::postFromRow(\Database::select(['*'], 'post_view', array('id' => $id))[0]);
    }

    public static function getMatchPosts(){
        $rows = \Database::call('GET_RANDOM_POST', []);
        return array(Post::postFromRow($rows[0]), Post::postFromRow($rows[1]));
    }

    public static function getPostsByUser($user) {
        $rows = \Database::select(['*'], 'post_view', array('author' => $user->getId()));
        $posts = array();

        foreach ($rows as $row) {
            $post = new Post($row['id'], $row['title'], $row['description'], $row['time'], $user, 0, $row['score']);
            array_push($posts, $post);
        }

        return $posts;
    }

    public static function getTopTen(){
        $rows = \Database::select(['*'], 'best_posts', []);
        $posts = array();

        foreach ($rows as $row) {
            array_push($posts, Post::postFromRow($row));
        }

        return $posts;
    }

    public function toggleLike() {
        $user = \Session::getUser();
        if ($user != NULL) {
            $this->userScore = \Database::call('TOGGLE_LIKE', [$user->getId(), $this->id])[0]['love'];
            $this->score = \Database::select(['score'], 'post_view', array('id_post' => $this->id))[0]['score'];
        }
    }

    public function toggleDislike() {
        $user = \Session::getUser();
        if ($user != NULL) {
            $this->userScore = \Database::call('TOGGLE_DISLIKE', [$user->getId(), $this->id])[0]['love'];
            $this->score = \Database::select(['score'], 'post_view', array('id_post' => $this->id))[0]['score'];
        }
    }

    public function save(){
        \Database::insert(array('id' => $this->id, 'title' => '\'' .$this->title. '\'', 'desc' => '\'' .$this->desc. '\'', 'author' => $this->author->getId()));
    }

    public function loadComments() {
        $this->comments = Comment::getCommentsByPost($this);
    }

    public function setTitle($title){
        $this->title = $title;
    }

    public function setDesc($desc){
        $this->desc = $desc;
    }

    public function setAuthor($author){
        $this->author = $author;
    }

    public function delete() {
        \Database::delete($this->id, 'post');
    }
}
?>
