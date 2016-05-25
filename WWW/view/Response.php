<?php
class Response{

  private $type;
  private $path;

  public function __construct($type,$path = null,$data = null) {
    $this->type = $type;
    $this->path = $path;
  }

  public function send() {
    switch ($type) {
      case 404: $this->send404('Error'); break;
      case 'json': $this->sendJson($data); break;
      case 'redirect': $this->sendRedirect($path); break;
      default: break;
    }
  }

  private function send404($errorMsg){
    header('HTTP/1.0 404 Not Found');
    Renderer::render404($errorMsg);
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
