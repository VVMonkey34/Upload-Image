<?php
require "autoload.php";
session_start();
$db = Db::singleton();

$pseudo = $_POST['pseudo'];
$src = $_FILES['image']['tmp_name'];
$filename = $_FILES['image']['name'];
$output_dir = "images/".$filename;
if (move_uploaded_file($src, $output_dir )) {
  

    $db -> update('user', ["user_img","pseudo"], [$filename,$pseudo], $_SESSION["mail"], "mail"); 

    
         header("location:profil.php");
} else{
    $filename;
     header("location:profil.php");
};
echo "<br>";

?>