<?php
include_once 'register.inc.php';
include_once 'functions.php';
?>

<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Secure Login: Registration Form</title>
		<script type="text/Javascript" src="js/sha512.js"></script>
		<script type="text/Javascript" src="js/forms.js"></script>
		<link rel="stylesheet" href="styles/main.css" />
	</head>
	<body>
	<!-- Registration form to be output if the POST variables are not set or if the registration script caused an error -->
	
	<?php
	if (!empty($error_msg)) {
		echo $error_msg;
	}
	?>
	<section class="container">
	<div class="login">
	<h1>Register with us</h1>
	<ul>
		<li>Usernames may contain only digits, upper and lower cases letters and underscores</li>
		<li>Emails must have a valid email format</li>
		<li>Passwords must be at least 6 characters long</li>
		<li>Passwords must contain
			<ul>	
				<li>At least one uppercase letter (A..Z)</li>
				<li>At least one lowercase letter (a..z)</li>
				<li>At least one number (0..9)</li>
			</ul>
		</li>
		<li>Your password and conformation must match exactly</li>
	</ul>
	<form action="<?php echo($_SERVER['PHP_SELF']); ?>"
			method="post"
			name="registration_form">
		<p><input type='text' name='username' id='username' placeholder='Username' /></p>
		<p><input type="text" name="email" id="email" placeholder='Email'/></p>
		<p><input type="password" name='password' id='password' placeholder='Password' /></p>
		<p><input type="password" name='confirmpwd' id='confirmpwd' placeholder='Confirm password' /></p>
		<p><input type="button" value="Register" onclick="return regformhash(this.form, this.form.username, this.form.email, this.form.password, this.form.confirmpwd);" /></p> 
        </form>
        <p>Return to the <a href="login.php">login page</a>.</p>
		</div>
		</section>
    </body>
</html>
								

