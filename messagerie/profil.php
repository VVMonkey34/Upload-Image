<?php

require "autoload.php";
session_start();
require_once("fonctions.php");

$compte= moncompte();
$pseudo = $compte["pseudo"]?? "";
$url = $compte["user_img"]?? "";

?><!doctype html>
<html lang="en">

<head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script src="main.js" defer></script>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- POLICE -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300&display=swap" rel="stylesheet">


</head>


<body class="text-white" >
        <div class="container-lg border border-3 w-50 mx-0">
        <a href="index.php"class="col-2 border border-2  p-2 mt-2 bg-sauman d-flex align-items-center  justify-content-center " style=" width:30px; height:30px;background-color:#FBCEB5;margin-left:97%; border-radius:50%; text-decoration:none;">x</a>
            <div class="row justify-content-center">
                <div class="col-md-6 text-center mb-5">
                    <h2 class="heading-section">My profil</h2>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="login-wrap p-0">

                    <div class="row">
                        <div class="col-lg-12 text-center mb-3"id="userPicture">
                            <div class="taille_image">
                                <img id="userPicture" src="images/<?= $url ?>"  style="width:100px;height:100px;object-fit:cover;border-radius:50%;background:gray;"   >
                            </div>
                        </div>
                    </div>
                        <h3 class="mb-4 text-center light">
                            <?php

                                echo "Bonjour <?=  $pseudo ?>"  ;

                            ?>
                        </h3>
                        <form action="saveprofil.php" class="signin-form" method="post">
                            <div class="form-group p-2">
                            <input class="form-control form-design" type="text" name="pseudo" id="pseudo" placeholder="pseudo" value="<?= $pseudo ?>" required>
                                <p id="error2"></p>
                            </div>
                            <div class="form-group p-2">
                            <input class=" form-control form-design image_class" type="file"  onchange="previewPicture(this)"  name="url" id="imageButton" placeholder="URL Image"  required>
                                <p id="error4"></p>
                            </div>
                            <div class="form-group">
                                <button type="button" class="form-control btn bg-saumon submit px-3 py-3 text-dark mb-3" id="saveButton">Save Profil</a></button> 
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>


