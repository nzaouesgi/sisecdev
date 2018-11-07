<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
</head>
<body>
<?php
	require_once(__DIR__."/functions.php");
	
	$_GET["evil"] = "😀 ' onfocus=alert(1) autofocus";
	$dangerousJSData = escapeForJavascript($_GET["evil"]);
?>
<script>
	window.onload = function (){
		//use quotes !!!
		let y = <?php echo "'".$dangerousJSData."'" ?>;

		x = document.createElement("input");
		x.setAttribute("value", y);
		document.body.appendChild(x);
	}
</script>

</body>
</html>