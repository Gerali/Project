<!DOCTYPE HTML>
<html>
<head>
</head>


<body>

<?php

	//maak een connectie
$con=mysqli_connect("localhost","root","","compictinfo");

//check de connectie
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}	


if(isset($_POST['kopNaam']))
{
	$kopNaam = $_POST['kopNaam'];
	$sql = "INSERT INTO  `compictinfo`.`koppen` (`kopId` ,`kopNaam`) VALUES (NULL ,  '$kopNaam');";
	mysqli_query($con, $sql);
}


if(isset($_POST['kopId']))
{
	$kopId = $_POST['kopId'];
	$contentKop = $_POST['contentKop'];
	$contentTekst = $_POST['contentTekst'];
	
	$sql ="INSERT INTO `compictinfo`.`content` (`contentId`, `kopId`, `contentKop`, `contentTekst`) VALUES (NULL, '$kopId', '$contentKop', '$contentTekst');";
	mysqli_query($con, $sql);
}

?>


<form method="POST">
Kopnaam: <input type="text" name="kopNaam"> <br />
<input type="submit" value="Voegtoe">
</form>

<form method="POST">
contentId: <input type="text" name="kopId"> <br />
contentId: <input type="text" name="contentKop"> <br />
contentId: <input type="text" name="contentTekst"> <br />
<input type="submit" value="Voegtoe">
</form>



</body>

</html>