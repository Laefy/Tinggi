<?php
namespace view;
class Renderer{

  private $title;
  private $view;
  private $currentUser;
  private $data;

  function __construct($title, $view, $currentUser, $data){
    $this->title = $title;
    $this->view = $view;
    $this->currentUser =$currentUser;
    $this->data = $data;
  }
  private static function render_header($VIEW_title){
    include \Router::$WEBROOT.'view/common/header.view.php';
  }

  private static function render_footer(){
    include \Router::$WEBROOT.'view/common/footer.view.php';
  }

  private static function render_nav($VIEW_user){
    include \Router::$WEBROOT.'view/common/nav.view.php';
  }

  public static function render_one($view, $data){
    include \Router::$WEBROOT.'view/'.$view;
  }

  public function render(){
    self::render_header($this->title);
    self::render_nav($this->currentUser);
    if(isset($this->view))
      self::render_one($this->view, $this->data);
    self::render_footer();
  }

  public static function renderError($VIEW_errorTitle, $VIEW_errorMsg) {
    self::render_header($VIEW_errorTitle);
    self::render_nav($this->currentUser);
    include \Router::$WEBROOT.'view/common/error.view.php';
    self::render_footer();
  }

  public static function renderJson($data) {
    echo json_encode($data);
  }

}
?>
