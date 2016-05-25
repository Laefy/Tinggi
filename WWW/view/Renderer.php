<?php
namespace view;
class Renderer{

  private $title;
  private $view;

  function __construct($title, $view){
    $this->title = $title;
    $this->view = $view;
  }
  private static function render_header($VIEW_title){
    include 'view/common/header.view.php';
  }

  private static function render_footer(){
    include 'view/common/footer.view.php';
  }

  private static function render_nav(){
    include 'view/common/nav.view.php';
  }

  public static function render_one($view, $data){
    include 'view/'.$view;
  }

  public function render($data){
    self::render_header($this->title);
    self::render_nav();
    if(isset($this->view))
      self::render_one($this->view, $data);
    self::render_footer();
  }

  public static function renderError($VIEW_errorTitle, $VIEW_errorMsg) {
    self::render_header($VIEW_errorTitle);
    include 'view/common/error.view.php';
    self::render_footer();
  }

  public static function renderJson($data) {
    echo json_encode($data);
  }

}
?>
