<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
</head>
<body>
<?php
	require_once(__DIR__."/functions.php");

	$_GET["evil"] = " '; </style> <input autofocus onfocus=\"alert('XSSed 😀')\">";
	
	//NOT SAFE
	//$dangerousCssString = $_GET["evil"];

	//SAFE
	$dangerousCssString = escapeForCSS($_GET["evil"]);
?>

<!-- XSS in generated CSS-->
<style>
	h4:after{
		content:<?php echo "'".  $dangerousCssString ."'" ?>;
		white-space: pre;
	}
</style>

<h4>Je suis un titre h4</h4>

</body>
</html>