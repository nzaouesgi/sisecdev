<?php

function escapeForHTML ($string){

	$escapedString = "";

	for ($i = 0; $i < mb_strlen($string); $i++){

		$char = mb_substr($string,$i,1);
		$charNumber = mb_ord ($char);

		if ($charNumber < 256 && !preg_match("#\w#", $char))
			$escapedString .= "&#x". dechex($charNumber). ";";
		else
			$escapedString .= $char;
	}

	return $escapedString;
}

function escapeForJavascript ($string){

	$escapedString = "";

	for ($i = 0; $i < mb_strlen($string); $i++){

		$char = mb_substr($string,$i,1);
		$charNumber = mb_ord($char);

		if ($charNumber < 256 && !preg_match("#\w#", $char))
			$escapedString .= "\\u". str_pad(dechex($charNumber),4 ,'0' ,STR_PAD_LEFT);
		else
			$escapedString .= $char;
	}

	return $escapedString;
}


function escapeForCSS ($string){

	$escapedString = "";

	for ($i = 0; $i < mb_strlen($string); $i++){

		$char = mb_substr($string,$i,1);
		$charNumber = mb_ord($char);

		if ( !preg_match("#[\w]#", $char))
			$escapedString .= "\\". str_pad(dechex($charNumber), 6 ,'0' ,STR_PAD_LEFT);
		else
			$escapedString .= $char;
	}

	return $escapedString;
}

function escapeForURLParameter ($string){

	$escapedString = "";

	for ($i = 0; $i < strlen($string); $i++){

		$char = substr($string,$i,1);
		$charNumber = ord($char);

		if (!preg_match("#[\w]#", $char)) 
			$escapedString .= "%". dechex($charNumber);
		else
			$escapedString .= $char;
	}

	return $escapedString;
}