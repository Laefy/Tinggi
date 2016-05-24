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
	Router::addRoute('top', 'controller\PostController', 'top');
	Router::addRoute('post/(\d+)', 'controller\PostController', 'read');
	Router::addRoute('post/new', 'controller\PostController', 'create');

	// Send the request to the good controller
	Router::execute($_GET['uri']);
?>
