<?php
//maak een connectie
$con=mysqli_connect("localhost","root","","compictinfo");
$result = mysqli_query($con,"SELECT * FROM koppen");

echo "
<div id='cssmenu'>
	<ul>
		<li class='active'><a href='opdracht wikiwijs.html'><span>Wikiwijs inhoud</span></a></li>";

while($row = mysqli_fetch_array($result)) 
{
  echo "<li class='has-sub'><a href='" .  $row['kopId'] . "'><span>";
  echo  $row['kopNaam']; 
  echo "</span></a>";
  
  echo "<ul>";
  $result2 = mysqli_query($con, "SELECT * FROM `content` WHERE `content`.`kopId` = " . $row['kopId']);
	while($row = mysqli_fetch_array($result2)) 
	{
		echo "<li><a href='index.php?pagId=" . $row['contentId'] .  "'><span>" . $row['contentKop'] . "</a></li>"; 
	}
  echo "</ul>";
  echo "</li>";
  

}
  echo "</div>";


//daadwerkelijke paginA
if(isset($_GET['pagId']))
{
	$pagId = $_GET['pagId'];
}
else
{
	$pagId = 1;
}
 $result3 = mysqli_query($con, "SELECT * FROM `content` WHERE `content`.`contentId` = " . $pagId);
while($row = mysqli_fetch_array($result3)) 
	{
			echo "<h2>" . $row['contentKop'] . "</h2>";
			echo $row['contentTekst'];
	}
 

/*
?>

<div id='cssmenu'>
<ul>
   <li class='active'><a href='index.html'><span>Home</span></a></li>
   <li class='has-sub'><a href='#'><span>Products</span></a>
      <ul>
         <li><a href='#'><span>Widgets</span></a></li>
         <li><a href='#'><span>Menus</span></a></li>
         <li class='last'><a href='#'><span>Products</span></a></li>
      </ul>
   </li>
   <li class='has-sub'><a href='#'><span>Company</span></a>
      <ul>
         <li><a href='#'><span>About</span></a></li>
         <li class='last'><a href='#'><span>Location</span></a></li>
      </ul>
   </li>
   <li class='last'><a href='#'><span>Contact</span></a></li>
</ul>
</div>


<div id='cssmenu2'>
	<ul>
		<li class='active'><a href='opdracht wikiwijs.html'><span>Wikiwijs inhoud</span></a></li>
		<li class='has-sub'><a href='ictlandstede.html'><span>ICT opleidingen Landstede Harderwijk</span></a>
			<ul>
				<li><a href='medewerkersict.html'><span>Medewerkers ICT Harderwijk</span></a></li>
				<li><a href='lesperioden.html'><span>Lesperioden</span></a></li>
				<li class='last'><a href='studiegids.html'><span>Studiegids</span></a></li>
			</ul>
		</li>
		<li class='has-sub'><a href='beroepspraktijkvorming.html'><span>BeroepsPraktijkVorming (BPV) </span></a>

		</li>
		<li class='last'><a href='llb.html'><span>Leren, Loopbaan en Burgerschap</span></a></li>
			<ul>
				<li><a href='nederlands.html'><span>Nederlands</span></a></li>
				<li><a href='engels.html'><span>Engels</span></a></li>
				<li><a href='rekenen.html'><span>Rekenen</span></a></li>
				<li><a href='burgerschap.html'><span>Burgerschap</span></a></li>
				<li><a href='loopbaan.html'><span>Loopbaan</span></a></li>
				<li class='last'><a href='portfolio.html'><span>Portfolio</span></a></li>
			</ul>
		<li class='has-sub'><a href='werkenleren.html'><span>Werken en leren binnen de opleiding</span></a>
			<ul>
				<li><a href='ictafdeling.html'><span>Werken op de ICT afdeling in Harderwijk</span></a></li>
				<li><a href='middlen.html'><span>Gebruik van middelen</span></a></li>
				<li><a href='huisregels.html'><span>Huisregels binnen de opleiding ICT&Technologie </span></a></li>
				<li class='last'><a href='coach.html'><span>Coaching van de studievoortgang</span></a></li>
			</ul>
		<li class='has-sub'><a href='pvb.html'><span>PVB-N2 en PVB-N3</span></a>
			<ul>
				<li class='last'><a href='roosters.html'><span>Roosters</span></a></li>
			</ul>
		<li class='has-sub'><a href='colofon.html'><span>Colofon</span></a>
	</ul>
</div>

<?php

*/

?>