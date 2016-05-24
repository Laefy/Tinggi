<?php
include 'Router.php';
require 'controller/Autoloader.php';
Autoloader::register();
Router::redirection($_GET['p']);
?>
