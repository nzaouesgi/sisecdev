<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
</head>
<body>
	<form method="post" enctype="x-www-form-urlencoded">
		<?php
			if (isset($_POST["action"]) && isset($_SESSION["csrf-token"]) && isset($_POST["token"]) ){
				if ($_POST["action"] === "delete"){
					if ($_POST["token"] === $_SESSION["csrf-token"])
						echo ( "Votre compte a été supprimé !<br>");
				}
			}
			$_SESSION["csrf-token"] = bin2hex(random_bytes(32));
		?>
		<label for="delete-account">Supprimer votre compte ?</label>
		<input type="hidden" value="delete" name="action">
		<input type="hidden" name="token" value=<?php echo "'".$_SESSION["csrf-token"]."'"; ?>>
		<button id="delete-account" type="submit">Valider</button>
	</form>
</body>
</html>