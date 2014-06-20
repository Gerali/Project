<?php
include_once 'db_connect.php';
include_once 'functions.php';
 
sec_session_start();
 
if (login_check($mysqli) == true) {
    $logged = 'in';
} else {
    $logged = 'out';
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Secure Login: Log In</title>
        <link rel="stylesheet" href="styles/main.css" />
        <script type="text/JavaScript" src="js/sha512.js"></script> 
        <script type="text/JavaScript" src="js/forms.js"></script>
    </head>
    <body>
        <?php
        if (isset($_GET['error'])) {
            echo '<p class="error">Error Logging In!</p>';
        }
        ?> 
	 <section class="container">
    <div class="login">
      <h1>Login to Wikiwijs</h1>
		<form method="post" action="process_login.php" name="login_form">
	  
        <p><input type="text" name="email" placeholder="Email"></p>
        <p><input type="password" name="password" id="password" placeholder="Password"></p>
        <p class="remember_me">
          <label>
            <input type="checkbox" name="remember_me" id="remember_me">
            Remember me on this computer
          </label>
        </p>
        <p class="submit"><input type="submit" value="Login" onclick="formhash(this.form, this.form.password);"></p>
		
		<p>If you don't have a login, please <a href="register.php">register</a></p>
        <p>If you are done, please <a href="logout.php">log out</a>.</p>
        <p>You are currently logged <?php echo $logged ?>.</p>
		
      </form>
    </div>
  </section>
</body>
</html>