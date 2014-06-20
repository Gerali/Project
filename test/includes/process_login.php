
<?php
include_once 'db_connect.php';
include_once 'functions.php';

sec_session_start(); //Onze custom beveiligde manier van het starten van een PHP session.

if (isset($_POST['email'], $_POST['p'])) {
	$email = $_POST['email'];
	$password = $_POST['p']; 	//De hashed wachtwoord
	
	if (login($email, $password, $mysqli) == true) {
		//Login succesvol
		header('Location: ../includes/protected_page.php');
	} else {
		//Login gefaald
		header('Location: ../includes/error.php?error=1');
		
	}
} else {
	//De juiste POST variabelen waren niet verzonden naar deze pagina
	echo 'Invalid Request';
}


?>
