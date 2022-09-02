<?php
session_start();
session_destroy();
header('location: ./index.php'); //deconnecte et redirige vers la page d'inscription ou connexion
exit;
?>

