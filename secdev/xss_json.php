<?php
require_once(__DIR__."/functions.php");

//XSS Successful if Content-Type is not set to application/json (default browser behavior). Will prevent XSS on most browsers.
header("Content-Type: application/json; charset=utf-8");
header("X-Content-Type-Options: nosniff");

$array = ["Value1" => "Bonjour 😀", "Value2" => "<input onfocus=alert(1) autofocus>"];

echo json_encode($array, JSON_PRETTY_PRINT);



