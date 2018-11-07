<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
</head>
<body>
<!-- XSS in URL parameter -->
<?php
	require_once(__DIR__."/functions.php");

	$_GET["evilWebsite"] = "http://secdev:5555/xss_url.php?param=";

	$_GET["evilParam"] = "😀' ><input autofocus onfocus='alert(1); ";

	$dangerousParam = escapeForURLParameter($_GET["evilParam"]);

	$dangerousURL = escapeForHTML($_GET["evilWebsite"]);
?>
<a href=<?php echo "'".$dangerousURL.$dangerousParam."'"?>>Click me</a>
</body>
</html>