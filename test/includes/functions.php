
<?php
	include_once 'psl-config.php';
	
	function sec_session_start() {
		$session_name = 'sec_session_id'; 	// Een custom session naam zetten 
		$secure = SECURE;
		// Dit stopt Javascript om toegang te krijgen op session id
		$httponly = true;
		if (ini_set('session.use_only_cookies', 1) === FALSE) {
        header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
        exit();
	}
	// Gets current cookies params.
	$cookieParams = session_get_cookie_params();
	session_set_cookie_params($cookieParams["lifetime"],
		$cookieParams["path"],
		$cookieParams["domain"],
		$secure,
		$httponly);
	// Sets the sessions name to the one set above.
	session_name($session_name);
	session_start();	// Start de PHP session
	session_regenerate_id(); 	//Regenerated the session, verwijderd de oude
}
	
	function login($email, $password, $mysqli) {
	// Omdat je prepared statements gebruikt betekent dat SQL injection niet mogelijk is
		if ($stmt = $mysqli->prepare("SELECT id, username, password, salt
			FROM members
			WHERE email = ?
			LIMIT 1")) {
			$stmt->bind_param('s', $email); 	//Bind "$email" to parameter
			$stmt->execute(); 	//Voert de prepared query
			$stmt->store_result();

			//Krijgt variables van resultaat
			$stmt->bind_result($user_id, $username, $db_password, $salt);
			$stmt->fetch();

			//Hash de wachtwoord met een unieke salt.
			$password = hash('sha512', $password . $salt);
			if ($stmt->num_rows == 1) {
			
				//Als gebruiker bestaat check of de account is gesloten
				//Van te veel login attempts
			if (checkbrute($user_id, $mysqli) ==true) {
			
			//Account is gesloten
			//Stuur een email naar de gebruiker om te zeggen dat hun account is gesloten
				return false;
			} else {
				//Check of de wachtwoord in de database matches
				//De wachtwoord dat de gebruiker heeft verzonden
				if ($db_password == $password) {
				//Wachtwoord is juist
				//Get the user-agent string of the user
				$user_browser = $_SERVER['HTTP_USER_AGENT'];
				//XSS protection as we might print this value
				$user_id = preg_replace("[^0-9]+/", "", $user_id);
				$_SESSION['user_id'] = $user_id;
				//XSS protection as we might print this value
				$username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username);
				$_SESSION['username'] = $username;
				$_SESSION['login_string'] = hash ('sha512', $password . $user_browser);
				//Login succesvol.
				return true;
			} else {
				//Wachtwoord is onjuist
				//We nemen dit poging op in de database
				$now = time();
				$mysqli->query("INSERT INTO login_attempts(user_id, time)
								VALUES ('$user_id', '$now')");
							return false;
						}
					}
				} else {
				// Gebruiker bestaat niet.
					return false;
				}
			}
		}
		
		function checkbrute($user_id, $mysqli) {
			//Krijg de tijdstamp van de huidige tijd
			$now = time();
			
			//Alle login pogingen worden geteld van het afgelopen 2 uur
			$valid_attempts = $now - (2 * 60 * 60);
			
			if ($stmt = $mysqli->prepare("SELECT time FROM login_attempts WHERE user_id = ? AND time > '$valid_attempts'")) {
				$stmt->bind_param('i', $user_id);
				
				//Voert uit de prepared query.
				$stmt->execute();
				$stmt->store_result();
				
				//Als er meer dan 5 gefaalde login pogingen zijn gebeurd
				if ($stmt->num_rows > 5) {
					return true;
				} else {
					return false;
				}
			}
		}
		
		function login_check($mysqli) {
			//Check of alle sessions variabelen klaar staan
			if (isset($_SESSION['user_id'],
								$_SESSION['username'],
								$_SESSION['login_string'])) {
								
				$user_id = $_SESSION['user_id'];
				$login_string = $_SESSION['login_string'];
				$username = $_SESSION['username'];

				
				//Get the user-agent string of the user.
				$user_browser = $_SERVER['HTTP_USER_AGENT'];
				
				if ($stmt = $mysqli->prepare("SELECT password FROM members WHERE id = ? LIMIT 1")) {
					//Bind "$user_id" to parameter.
					$stmt->bind_param('i', $user_id);
					$stmt->execute();		//Voer de prepared query uit
					$stmt->store_result();
				
					if ($stmt->num_rows == 1) {
						//Als gebruiker bestaat krijg variabelen van resultaat
						$stmt->bind_result($password);
						$stmt->fetch();
						$login_check = hash('sha512', $password . $user_browser);
						
						if ($login_check == $login_string) {
							// Ingelogd!!!
							return true;
						} else {
							//Niet ingelogd!!!
							return false;
						}
					} else {
						//Niet ingelogd!!!
						return false;
					} 
				} else {
					//Niet ingelogd!!!
						return false;
				}
			} else {
				//Niet ingelogd!!!
					return false;
				}
			}
		
		function esc_url($url) {
		
			if ('' == $url) {
				return $url;
			}
			
			$url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);
			
			$strip = array('%0d', '%0a', '%0D', '%0A');
			$url = (string) $url;
 
			$count = 1;
			while ($count) {
				$url = str_replace($strip, '', $url, $count);
			}
 
			$url = str_replace(';//', '://', $url);
 
			$url = htmlentities($url);
 
			$url = str_replace('&amp;', '&#038;', $url);
			$url = str_replace("'", '&#039;', $url);
			
			if ($url[0] !== '/') {
				//We zijn alleen geïnteresseerd in relative links van $_SERVER['PHP_SELF']
				return '';
			} else {
				return $url;
			}
		}
	
?>		