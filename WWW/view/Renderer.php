<?php
class Renderer{

  private static function render_header(){
    self::render_one('common/header.view.php');
  }

  private static function render_footer(){
    self::render_one('common/header.view.php');
  }

  private static function render_nav(){
    self::render_one('common/nav.view.php');
  }

  public static function render_one($view){
    include 'view/'.$view;
  }

  public static function render($view){
    self::render_header();
    self::render_nav();
    self::render_one($view);
    self::render_footer();
  }

  public static function render404() {
    self::render('common')
  }

  public static function renderJson($data) {
    echo json_encode($data);
  }

}
?>
