<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
</head>
<body>
<?php
	require_once(__DIR__."/functions.php");

	$_GET["evil"] = "'😀     autofocus  onfocus='alert(1)  ";
	
	//NOT SAFE.
	$dangerousAttributeData = htmlentities($_GET["evil"]);
 
	//SAFE ONLY IF ATTRIBUTE IS QUOTED.
	$dangerousAttributeData = htmlentities($_GET["evil"], ENT_QUOTES, 'UTF-8');

	// SAFE.
	$dangerousAttributeData = escapeForHTML($_GET["evil"]);

	// potential XSS vulnerability in HTML attribute.
	echo "<input type='text' value=".$dangerousAttributeData." >\r\n";
?>
</body>
</html>