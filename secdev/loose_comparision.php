<?php
//This one is for demonstrating how comparisions can be exploited in PHP when user input is supplied.
//This broken authentication system will compare the user's hash in database with the hash supplied by user.
//First code goes with with strcmp function, and second piece of code comes with the '==' loose comparision operator.
//For more info, go to http://repository.root-me.org/Exploitation%20-%20Web/EN%20-%20PHP%20loose%20comparison%20-%20Type%20Juggling%20-%20OWASP.pdf

//Take note that everything occuring here can be found anywhere, in any functionnality, in any piece of code.

//HOW TO AVOID SUCH VULNERABILITIES ?
//Stay safe and use === and !== instead of the bad == and !=
//Always check your functions return values.
//Validate user input.
//Check types when using JSON.

//Choose the payload.
$payload = 4;

switch($payload){

	case 1:
		// Payload #1: boolean
		// This will always give true when comparing to a string.
		$_POST["auth"] = '{"user" : "admin", "password" : true }';
		break;
	case 2:
		// Payload #2: integer
		// This will always give true when comparing to a string.
		$_POST["auth"] = '{"user" : "admin", "password" : 0 }';
		break;
	case 3:
		// Payload #3: array
		// This will return null ( null == 0 ) when using in strcmp.
		$_POST["auth"] = '{"user" : "admin", "password" : [] }';
		break;
	case 4:
		// Payload #4: string
		// This will work in any context (not only when input is supplied with JSON since $_POST contains strings).
		// If compared hash is zero-like, this will bypass the auth.
		// Zero-like hash starts with 0e, it can be interpreted as being a 0 with a pow value (which is always equal to 0) in the context of a loose comparision vulnerability.
		// Some zero-like hashes:
		/*
			md5: 240610708 (0e462097431906509019562988736854)
			sha1: 10932435112 (0e07766915004133176347055865026311692244)
		*/
		$_POST["auth"] = '{"user" : "admin", "password" : "0" }';
		break;
}

//JSON as user input can be very dangerous, since users are not forced to input only strings.
$authData = json_decode($_POST["auth"], true);


//Setting up fake database for demonstration purpose.
//Admin's password hash is sha1, and is zero-like. 
//Clear text password: 10932435112
$credentials = ["admin" => "0e07766915004133176347055865026311692244"];
if (!array_key_exists($authData["user"], $credentials))
	die("User doesn't exist.");

//Loose comparisions causes vulnerable authentication:

//Choose the vulnerable code to run, from 1 to 2.
$code = 2;

switch ($code){
	case 1:

		//strcmp() should be compared like this: strcmp() === 0
		//Comparing [] (array) with strcmp returns null, which is just like 0 (int) when doing loose comparision.
		//Here payload #3 will work (and will emit warning as well, which doesn't stop code execution).

		if (strcmp($authData["password"], $credentials[$authData["user"]]) == 0)
			die( "Authenticated as ".$authData["user"]);
		else
			die("Login failed.");

		break;

	case 2:

		//Basic string comparision can cause vulnerability.
		//If password is set to true(boolean) or 0 if the compared hash is zero-like, auth is bypassed.
		//Here payload 1 will work and payload 2 will work, but not all the time.

		if ($authData["password"] == $credentials[$authData["user"]])
			die( "Authenticated as ".$authData["user"]);
		else
			die("Login failed.");

		break;
}


