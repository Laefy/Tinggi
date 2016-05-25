<?php

$maxSize=1048576;
$destination= '/upload';
$extensions= array( 'jpg' , 'jpeg' , 'gif' , 'png' );
function upload($index,$destination, $maxSize,$extensions)
{
	if($_FILES[$index]==$_FILES['img']){
		if (!isset($_FILES[$index]) OR $_FILES[$index]['error'] > 0) return FALSE;

		if ($maxSize !== FALSE AND $_FILES[$index]['size'] > $maxSize) return FALSE;
		$ext = substr(strrchr($_FILES[$index]['name'],'.'),1);
		$nom = uniqid(rand(), true);
		if ($extensions !== FALSE AND !in_array($ext,$extensions)) return FALSE;
		return move_uploaded_file($_FILES[$index]['tmp_name'],$destination.$nom.'.'.$ext);
	}	
	
	if($_FILES[$index]==$_FILES['video']){
		if (!isset($_FILES[$index]) OR $_FILES[$index]['error'] > 0) return FALSE;
		return $_POST['video'];
	}	
	
	if($_FILES[$index]==$_FILES['texte']){
		if (!isset($_FILES[$index]) OR $_FILES[$index]['error'] > 0) return FALSE;		
		return $_POST['texte'];	
	}	
	
	
}


upload('img',$destination,$maxSize, $extensions);
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>	

		<form method="post" action="upload.php" enctype="multipart/form-data">

			 <label for="img">Image (JPG, PNG ou GIF | max. 1 Mo) :</label><br />
			 <input type="file" name="img" id="img" /><br />

			 <label for="video">Lien vidéo </label><br />
			 <input type="text" name="video" value="Titre du fichier" id="video" /><br />

			 <label for="texte">Texte</label><br />
			 <textarea name="texte" id="texte"></textarea><br />
			 
			 <label for="titre">Titre </label><br />
			 <input type="text" name="titre" value="Titre du fichier" id="titre" /><br />

			 <label for="description">Description  (facultatif) </label><br />
			 <textarea name="description" id="description"></textarea><br />

			 <input type="submit" name="submit" value="Envoyer" />

		</form>

	</body>
</html>