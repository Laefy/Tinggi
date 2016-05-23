<?php
use controller\MainController as MainController;
use model\MainModel as MainModel;
session_start();
require_once("./Controller/Autoloader.php");
Autoloader::register();
MainController::initRouter();
$w = new MainModel(".","Page Test");
?>
<!DOCTYPE html>
<html>
	<head>
	<?php $w->buildHeader(); ?>
	</head>
	<body onresize="resize()">
		<div class="bloc_page">Kikou
		</div>
	</body>
</html>
