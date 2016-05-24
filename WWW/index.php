<?php
	session_start();
	include 'Router.php';
	require 'controller/Autoloader.php';
	Autoloader::register();
	Router::initRouter();
	$MainController= Router::handleRequest($_GET['p']);
	if(!isset($MainController)){
		exit(0);
	}
	$MainController->init();
?>
<!DOCTYPE html>
<html>
  <head>
    <?php $MainController->buildHeader('main.css','tinggi.png'); ?>
  </head>
  <body>
    <?php $MainController->render();?>
  </body>
</html>
