<?php
session_start();
require 'autoload.php';


$db = Db::singleton();
$user = $db -> select_one('user',"mail",$_POST["mail"]);



if (empty($user)) {

    header ('location : ./signup.php');
} 

else if ($_POST["pwd"] == $user["password"]) {
    
    $_SESSION["mail"] = $_POST["mail"];

    header ('location: ./index.php');
}

?>