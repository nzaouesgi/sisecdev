<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
</head>
<body>
<?php
	require_once(__DIR__."/functions.php");

	$data["Value1"] = "Bonjour 😀";
	$data["Value2"] = '<sCrIpT SrC  =  http://xss.rocks/xss.js></sCrIpT>';

	$json = json_encode($data);

	//escape before printing in HTML context.
	$json = escapeForHTML($json);

	echo "<h4>DOM data:</h4>";
	echo "<div id='init-data'>".$json."</div>";
?>
<script>

	/*
		Using textContent is better and safer than using innerHTML since this property defines text value inside a node.
		It will prevent XSS and it's much faster as well. 
		The data is not compromised within the script, but it's escaped when added to the DOM.
		(if we had used innerHTML, it would have worked the same way, but the data is compromised within the script).
		NEVER USE textContent AFTER/BEFORE innerHTML in this context.
	*/

	// FIRST CASE. JSON is parsed in the DOM, displayed in the console, and then re-inserted into the DOM.
	window.addEventListener( "load", function (){
		let data = document.getElementById("init-data").textContent;
		let json = JSON.parse(data);

		console.log(json);
		
		let p = document.createElement("p");
		p.textContent = "Loaded from DOM: " + JSON.stringify(json);
		document.body.appendChild(p);
	});

	// SECOND CASE. JSON is fetched using XHR, displayed in the console, and then inserted in to the DOM
	window.addEventListener("load",function (){
		let request = new XMLHttpRequest();
		request.onreadystatechange = function (){
			if (this.readyState === XMLHttpRequest.DONE){

				let json = JSON.parse(this.responseText);

				console.log(json);

				let p = document.createElement("p");
				p.textContent = "Loaded from XMLHttpRequest: " + JSON.stringify(json);
				document.body.appendChild(p);
			}
		}

		request.open( "GET", "xss_json.php", true);
		request.send();
	});

</script>
</body>
</html>
