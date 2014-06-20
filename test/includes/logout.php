
<?php

include_once 'functions.php';
sec_session_start();

//Unset alle sessions values
$_SESSION = array();

//get sessions parameters
$params = session_get_cookie_params();

//Verwijder de actuele cookie.
setcookie(session_name(),
		'', time() - 42000,
		$params["path"],
		$params["domain"],
		$params["secure"],
		$params["httponly"]);
		
//Vernietig session
session_destroy();
header('Location: ../includes/login.php');

?>
