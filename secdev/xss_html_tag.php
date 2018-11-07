<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
</head>
<body>
<?php
	require_once(__DIR__."/functions.php");

	$_GET["evil"] = "<script>alert('XSS 😀'); </script>";

	// NOT SAFE
	$dangerousInnerHTMLData = $_GET["evil"];

	//SAFE, BUT ONLY IN THIS CONTEXT. NOT RECOMMENDED.
	$dangerousInnerHTML = htmlentities($dangerousInnerHTML);

	// SAFE.
	$dangerousInnerHTMLData  = escapeForHTML($_GET["evil"]);
	
	// XSS in a an HTML entity's content.
	echo "<div>".$dangerousInnerHTMLData."</div>\r\n";


?>
</body>
</html>