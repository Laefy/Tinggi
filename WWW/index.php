<?php
session_start();
require_once("./Model/MainModel.php");
require_once("./Controller/MainController.php");
MainController::initRouter();
$w = new Tinggi(".","Page Test");
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
