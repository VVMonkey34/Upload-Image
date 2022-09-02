<?php

session_start();

require "autoload.php";

$db = Db::singleton();

$mail = $_POST["mail"];
$pwd = $_POST["pwd"]; 

$db -> create('user', [ "mail", "password"], [$mail, $pwd]);

// Connexion directe après inscription
$_SESSION["mail"]= $_POST["mail"];

header('Location: ./index.php');

?>