<?php
session_start();

require "../autoload.php";




?><!doctype html>
<html>
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Favicon -->
	<!-- <link rel="icon" href="./assets/image/favicon-32x32.png" type="image/gif" sizes="32x32"> -->
	<!-- <link rel="shortcut icon" href="./assets/image/favicon-32x32.png" type="image/gif" sizes="32x32"> -->
	<!-- <link rel="apple-touch-icon" href="./assets/image/apple-touch-icon.png" type="image/gif"> -->
	<!-- Google Font CDN -->
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
	<!-- Fontawesome -->
	<script src="https://kit.fontawesome.com/886c286f97.js" crossorigin="anonymous"></script>
	<!-- Main CSS -->
	<link rel="stylesheet" href="./assets/css/style.css">
	<!-- script darkmode-->
	<script src="https://cdn.jsdelivr.net/npm/darkmode-js@1.5.7/lib/darkmode-js.min.js"></script>
<script>
	var me= "<?=  $_SESSION["mail"]  ?>";
	console.log(me);
</script>
	<title>WhatsApp</title>
</head>

<body onload="init()">
	<!-- ici on définie une taille maximale et minimale, puis on donnera un overflow au contenu des sous partie pour avoir les 2 scroll -->
	<div class="container-fluid d-flex px-0" style="max-height: 100vh; min-height: 100vh;">

		<!-- ci-dessous : ecran liste des messages (partie de gauche en vue PC)-->
		<!-- ici on modifiera la classe en js pour changer d'affichage entre partie gauche et droite -->
		<div class="col-12 col-lg-4 flex-column d-flex d-lg-flex" id="viewList">
			<!-- ecran liste : navbar top -->
			<nav class="navbar py-0 px-3 bg-turnGreenToGrey bg-success">
				<ul class="col-6 navbar-nav">
					<li class="nav-item">
						<a class="navbar-brand d-none d-lg-flex" href="#">
							<div class="petite_photo">
								<img src= "<?=  $compte['user_img'] ?>">
							</div>
						</a>
					</li>
					<li class="nav-item">
						<a class="navbar-brand d-flex d-lg-none" href="#">
							<h2 class="text-white">WhatsApp</h2>
						</a>
					</li>
				</ul>
				<ul class="col-6  navbar-nav flex-row ">
					<li class="nav-item p-2 m-2">
						<a href="#" class="nav-link d-lg-none">
							<i class="fa-solid fa-magnifying-glass text-white hoverscale"></i>
						</a>
					</li>
					<li class="nav-item p-2 m-2 d-none d-lg-flex">
						<a href="#" class="nav-link"  onclick="show_discussions()" >
							<i class="fa-solid fa-message text-white color-change hoverscale"></i>
						</a>
					</li>
					<li class="nav-item p-2 m-2 d-none d-lg-flex">	<a href="#" class="nav-link"  onclick="show_contacts()" >
							<i class="fa-solid fa-user text-white color-change hoverscale"></i>
						</a>
					</li>
					<li class="nav-item p-2 m-2">
						<a href="../index.php" class="nav-link">
							<i class="fa-solid fa-ellipsis-vertical text-white color-change hoverscale"></i>
						</a>
					</li>
				</ul>
			</nav>
			<!-- ecran liste : searchbar visible que en PC -->
			<form class="form-search form-inline bg-light d-none d-lg-flex p-2 ">
				<div class="container d-flex bg-white rounded">
					<i class="fa-solid fa-magnifying-glass text-secondary m-3 me-0 hovergreen hoverscale"></i>
					<input type="text" class="form-control search-query border-0" placeholder="Search or start new chat" />
				</div>
			</form>
			<!-- ecran liste : nav niveau2 visible que en mobile -->
			<div class="navbar bg-success d-flex d-lg-none p-0 m-0">
				<ul class="col-1 navbar-nav p-0 m-0 ">
					<li class="nav-item p-1 m-0 hover hoverscale">
						<a href="#" class="py-0 pb-2 nav-link d-flex align-items-center justify-content-center">
							<i class="fa-solid fa-camera text-white "></i>
						</a>
					</li>
				</ul>
				<ul class="col-11 navbar-nav flex-row">
					<li class="col nav-item p-0 m-0 hover">
						<a href="#" class="py-0 pb-2 nav-link text-white fw-bold text-center text-uppercase ">chats</a>
					</li>
					<li class="col nav-item p-0 m-0 hover">
						<a href="#" class="py-0 pb-2 nav-link text-white fw-bold text-center text-uppercase">status</a>
					</li>
					<li class="col nav-item p-0 m-0 hover">
						<a href="#" class="py-0 pb-2 nav-link text-white fw-bold text-center text-uppercase">calls</a>
					</li>
				</ul>
			</div>
			<hr class="m-0 mb-2 text-secondary">
			<!-- ecran liste : listes des conversations -->
			<div class="container-fluid overflow-auto pl-0" id="msg-list">
				<!-- ici on injecte la liste de messages -->
			</div>
			<a href="#" class="d-flex d-lg-none position-absolute hoverscale" style="bottom: 15px; right: 15px;" id="messagelogo">
				<i class="fa-solid fa-message text-white bg-success rounded-pill p-3"></i>
			</a>
		</div>

		<!-- ci-dessous : ecran conversation (partie de droite en vue PC)-->
		<!-- ici on modifiera la classe en js pour changer d'affichage entre partie gauche et droite -->
		<div class="col-12 col-lg-8 flex-column d-none d-lg-flex" id="viewMessages">
			<!-- ecran conversation : navbar top -->
			<nav class="navbar py-0 px-3 bg-turnGreenToGrey bg-success">
				<ul class="navbar-nav d-flex flex-row">
					<li class="nav-item p-2 m-2 ms-0 ps-0">
						<a href="#" class="nav-link" onclick="backToList()">
							<i class="fa-solid fa-arrow-left color-change text-white hoverscale"></i>
						</a>
					</li>
					<li class="nav-item d-flex" id="interlo">
						<!-- ici on injecte le nom de l'interlocuteur / le titre de la conversation -->
					</li>
				</ul>
				<ul class="navbar-nav flex-row">
					<li class="nav-item p-2 m-2 d-flex d-lg-none">
						<a href="#" class="nav-link">
							<i class="fa-solid fa-video color-change text-white hoverscale"></i>
						</a>
					</li>
					<li class="nav-item p-2 m-2 d-flex d-lg-none">
						<a href="#" class="nav-link">
							<i class="fa-solid fa-phone color-change text-white hoverscale"></i>
						</a>
					</li>
					<li class="nav-item p-2 m-2 d-none d-lg-flex">
						<a href="#" class="nav-link">
							<i class="fa-solid fa-paperclip color-change text-white hoverscale"></i>
						</a>
					</li>
					<li class="nav-item p-2 m-2">
						<a href="#" class="nav-link">
							<i class="fa-solid fa-ellipsis-vertical color-change text-white hoverscale"></i>
						</a>
					</li>
				</ul>
			</nav>
			<!-- ecran conversation : partie messages -->
			<div class="container-fluid h-100 p-3 bg-info bg-opacity-10 bg-turnInfoToWarning overflow-auto d-flex flex-column d " id="conversations">
				<!-- ici on injecte notre conversation, les messages reçus et envoyés -->
			</div>
			<!-- ecran conversation : navbar bottom -->
			<div class="container-fluid d-flex bg-turnGreenToGrey justify-content-center p-1 ps-5 ps-lg-1">

				<div class="nav-item d-none d-lg-flex align-items-center justify-content-center m-1 me-2 p-3 bg-success rounded-circle hoverscale" style="width: 50px; height: 50px;">
					<a href="#" class="nav-link" onclick="envoyer_message()">
						<i class="fa-solid fa-microphone text-white p-1"></i>
					</a>
				</div>

				<div class="container d-flex bg-white rounded-pill align-items-center border ms-4 ms-lg-0">
					<a href="#" class="nav-link"><i class="fa-solid fa-face-grin text-secondary m-2 hovergreen hoverscale"></i></a>
					<input type="text" class="form-control search-query border-0" id="chat" placeholder="Type a message" />
					<a href="#" class="nav-link"><i class="fa-solid fa-paperclip text-secondary m-2 me-0 hovergreen hoverscale"></i></a>
					<a href="#" class="nav-link"><i class="fa-solid fa-camera-retro text-secondary m-2 hovergreen hoverscale"></i></a>
				</div>

				<div class="nav-item d-flex align-items-center justify-content-center m-1 ms-2 p-3 bg-success rounded-circle hoverscale" style="width: 50px; height: 50px;">
					<a href="#" class="nav-link " onclick="envoyer_message()" id="envoyer_message">
						<i class="fa-solid fa-paper-plane text-white p-1"></i>
					</a>
				</div>
			</div>
		</div>

	</div>
	<!-- Bootstrap Bundle with Popper -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<!-- Main JS -->
	<!-- <script src="./assets/js/main.js"></script> -->
	<script src="./assets/js/script-m.js"></script>
</body>

</html>