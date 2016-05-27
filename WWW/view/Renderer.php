<?php
namespace view;

class Renderer{

  private $title;
  private $view;
  private $data;

  function __construct($title, $view, $data = []){
    $this->title = $title;
    $this->view = $view;
    $this->data = $data;
  }
  private static function render_header($title){
    include \Router::$WEBROOT.'view/common/header.view.php';
  }

  private static function render_footer(){
    include \Router::$WEBROOT.'view/common/footer.view.php';
  }

  private static function render_nav(){
    include \Router::$WEBROOT.'view/common/nav.view.php';
  }

  public static function render_one($view, $data){
    include \Router::$WEBROOT.'view/'.$view;
  }

  public function render(){
    self::render_header($this->title);
    self::render_nav();
    if(isset($this->view))
      self::render_one($this->view, $this->data);
    self::render_footer();
  }

  public static function renderError($VIEW_errorTitle, $VIEW_errorMsg) {
    self::render_header($VIEW_errorTitle);
    self::render_nav();
    include \Router::$WEBROOT.'view/common/error.view.php';
    self::render_footer();
  }

  public static function renderJson($data) {
    echo json_encode($data);
  }

  public static function render_errors($data) {
    if(isset($data['error']) && isset($data['errors']))
    {
      include \Router::$WEBROOT.'view/common/errors.alert.view.php';
    }
  }
}
?>
