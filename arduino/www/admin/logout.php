<?php

	//Distruggo la sessione utente admin e faccio redirect a pagina di login

	setcookie("Login-ArduDisplay", "", time() - (86400 * 30), "/");

	header("Location: index.php");
	
?>