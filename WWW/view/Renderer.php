<?php
class Renderer{

  private var $title;
  private var $view;

  function __construct($title, $view){
    $this->title = $title;
    $this->view = $view;
  }
  private static function render_header($VIEW_title){
    self::render_one('common/header.view.php');
  }

  private static function render_footer(){
    self::render_one('common/footer.view.php');
  }

  private static function render_nav(){
    self::render_one('common/nav.view.php');
  }

  public static function render_one($view){
    include 'view/'.$view;
  }

  public function render(){
    self::render_header($this->title);
    self::render_nav();
    if(isset($this->view))
      self::render_one($this->view);
    self::render_footer();
  }

  public static function render404($VIEW_errorMsg) {
    self::render_header("Error404");
    self::render_nav();
    self::render_one("error.php");
    self::render_footer();
  }

  public static function renderJson($data) {
    echo json_encode($data);
  }

}
?>
