<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
</head>
<body>
<?php
require_once(__DIR__."/functions.php");

// XSS in generated JS script.
$_GET["evil"] = "fakeData';\r\nalert('XSSed 😀');\r\nlet iCanDo = 'WhatIWant";

// escape data before inserting in script.
$dangerousJSData = escapeForJavascript($_GET["evil"]);

?>
<script>
	window.onload = function (){
		// data must be quoted.
		let data = <?php echo  "'". $dangerousJSData ."'"; ?>;

		let output =  document.createElement("div");
		output.innerHTML = data + " (" + typeof data + ")";
		document.body.appendChild(output);
	}
</script>
</body>
</html>