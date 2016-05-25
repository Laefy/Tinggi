<?php
namespace view;

class Response{

  private $type;
  private $path;

  public function __construct($type,$path = null,$data = null) {
    $this->type = $type;
    $this->path = $path;
  }

  public function send($param) {
    switch ($this->type) {
      case 'error': $this->sendError($param['title'],$param['msg']); break;
      case 'json': $this->sendJson($data); break;
      case 'redirect': $this->sendRedirect($path); break;
      default: break;
    }
  }

  private function sendError($errorTitle, $errorMsg){
    header('HTTP/1.0 404 Not Found');
    Renderer::renderError($errorTitle,$errorMsg);
    exit(0);
  }

  private function sendJson($data){
    header('Content-Type: application/json');
    Renderer::renderJson($data);
    exit(0);
  }

  private function sendRedirect($path){
    header('Location : '.$path);
    exit(0);
  }
}
?>
