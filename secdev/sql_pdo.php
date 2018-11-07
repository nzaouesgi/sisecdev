<?php

$_POST["id"] = 1;
$_POST["name"] = "admin";

/* Connexion à une base MySQL avec l'invocation de pilote */
require_once("database_secrets.php");

try {
    $pdo = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
    echo 'Connexion échouée : ' . $e->getMessage();
    die();
}

$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

//Exemple d'utilisation de PDO #1

//Filtrage de type whitelist (si l'entrée n'est pas un entier alors $userId sera converti en 0)
$userId = intval($_POST["id"]);

//Préparation de la requête
$query = $pdo->prepare("SELECT * FROM user WHERE id = :foo ");
//Paramétrage de la requête par référence.
$query->bindParam( ":foo", $userId, PDO::PARAM_INT);

//Exécution de la requête
$query->execute();

//Récupération du premier résultat
$results = $query->fetch(PDO::FETCH_ASSOC);

echo "<h4>1ère requête.</h4>";
var_dump($results);

//Modification de la valeur à la référence paramétrée pour le champ :foo de la requête
$userId++;
//Deuxième exécution de la requête
$query->execute();

//Récupération du nouveau résultat
$results = $query->fetch(PDO::FETCH_ASSOC);

echo "<h4>2ème requête.</h4>";
var_dump($results);

//Exemple d'utilisation de PDO #2

$username = $_POST["name"];

//Filtrage de type whitelist
if (preg_match("#^[a-zA-Z0-9]+$#", $username)){

	//Préparation de la requête
	$query = $pdo->prepare("SELECT * FROM user WHERE name = :foo ");
	//Paramétrage de la requête par valeur
	$query->bindValue( ":foo", $username, PDO::PARAM_STR);

	//Exécution de la requête
	$query->execute();

	//Récupération du résultat
	$results = $query->fetch(PDO::FETCH_ASSOC);

} else {
	$results = false;
}

echo "<h4>3ème requête.</h4>";
var_dump($results);