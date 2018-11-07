<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
</head>
<body>
	<form method="get">
		<?php
			if (isset($_GET["action"])){
				if ($_GET["action"] === "delete"){
					echo ( "Votre compte a été supprimé !<br>");
				}
			}
		?>
		<label for="delete-account">Supprimer votre compte ?</label>
		<input type="hidden" value="delete" name="action">
		<button id="delete-account" type="submit">Valider</button>
	</form>
</body>
</html>