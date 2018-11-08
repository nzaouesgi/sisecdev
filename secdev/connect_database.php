<?php
$dsn = 'mysql:dbname=test;host=127.0.0.1';
$user = 'root';
$password = '';

try {
    return  new PDO($dsn, $user, $password);
} catch (PDOException $e) {
    return false;
}
