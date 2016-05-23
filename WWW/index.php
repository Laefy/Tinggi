<?php
session_start();
require_once("./Controller/Autoloader.php");
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
