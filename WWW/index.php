<?php
	// debug
	error_reporting(E_ALL);
	ini_set('display_errors', 'on');

	// imports
	require 'Autoloader.php';
	require 'Database.php';

	// initialisations
	Autoloader::register();
	Session::init();
	Router::init();

	// Add Routes
	Router::addRoute('signin', 'controller\UserController', 'signIn');
	Router::addRoute('signout', 'controller\UserController', 'signOut');
	Router::addRoute('signup', 'controller\UserController', 'signUp');
	Router::addRoute('user/(\w+)', 'controller\UserController', 'edit');

	Router::addRoute('', 'controller\PostController', 'index');
  Router::addRoute('match', 'controller\PostController', 'index');
	Router::addRoute('top', 'controller\PostController', 'top');
	Router::addRoute('post/(\d+)', 'controller\PostController', 'read');
	Router::addRoute('post/new', 'controller\PostController', 'create');
  Router::addRoute('post/send', 'controller\PostController', 'send');
	Router::addRoute('post/toggleLike/(\d+)', 'controller\PostController', 'like');
	Router::addRoute('post/toggleDislike/(\d+)', 'controller\PostController', 'dislike');

	Router::addRoute('post/comment/(\d+)', 'controller\CommentController', 'send');
	Router::addRoute('signup/new', 'controller\UserController', 'validsignup');
	Router::addRoute('signin/valid', 'controller\UserController', 'validsignin');

	// Send the request to the good controller
	Router::execute($_GET['uri']);
?>
