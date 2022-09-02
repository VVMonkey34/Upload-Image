<?php 

spl_autoload_register(
    function( $classname){
        include strtolower($classname). ".class.php";
    }
  );





?>