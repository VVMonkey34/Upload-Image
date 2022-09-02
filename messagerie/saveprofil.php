<?php
session_start();

require "autoload.php";

$db = Db::singleton();
$db -> update('user', ["user_img", "pseudo"], [$_POST["url"],$_POST["pseudo"]], $_SESSION["mail"], "mail"); 


header('Location: ./index.php');

?>