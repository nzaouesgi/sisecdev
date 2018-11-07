<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
</head>
<body>
<?php
	require_once(__DIR__."/functions.php");
	
	$_GET["evil"] = "<script>alert(\"xss 😀\");</script>";
	$dangerousJSData = escapeForJavascript($_GET["evil"]);
?>

<script>
	window.onload = function (){
		let x = <?php echo "'". $dangerousJSData ."'"?>;

		console.log(x);

		let p = document.createElement('p');
		p.textContent = x;
		document.body.appendChild(p);
	}
</script>

</body>
</html>