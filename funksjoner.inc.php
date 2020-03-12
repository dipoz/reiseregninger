<?php

//Funksjon for å gjøre det lettere å koble til en database
//og lettere å endre i koden i fall det blir nye "credentials"
function kobleTil ($databasenavn=""){
	//for lokal tilkobling:
	//$vert = "localhost";
	//$bruker = "root";
	//$passord = "root";
	$vert = "";
	$bruker = "";
	$passord = "";
	$conn = mysqli_connect($vert, $bruker, $passord, $databasenavn);
	// Check connection
	if (!$conn) {
	    die("Connection failed: " . mysqli_connect_error());
	}
//sjekk:
	//echo "Connected successfully";
	return $conn; //skjer bare hvis alt gikk bra
}//kobleTil


//Funksjon for felles footer for alle sider:
function Footer() {

	echo  "<footer id='sticky-footer' class='footer ixed-top bg-dark'>";
  echo "<div class='container'>";
  echo "<p class='m-0 text-center text-white'>Kontakter</p>";
  echo "<p class='m-0 text-center text-white'>";
  echo "<i class='fa fa-home mr-3'></i> Storgata 5, 4005 Stavanger</p>";
  echo "<p class='m-0 text-center text-white'>";
  echo "<i class='fa fa-envelope mr-3'></i>reiser@reiser.com</a></p>";
  echo "<p class='m-0 text-center text-white'>";
  echo "<i class='fa fa-phone mr-3'></i> + 47 12 34 56 78</p>";
  echo "</div>";
	echo "</footer>";
}

//Funksjon for å finne gjennomsnitt:
function finnGjennomsnitt($totalt, $antall) {
	$gjennomsnitt = $totalt / $antall;
	$formattedgjennomsnitt = number_format($gjennomsnitt, 0, '.','');
	return $formattedgjennomsnitt;

}

//Funksjon for navbar som er lik for alle sider:
Function Navbar() {
	echo "<div class='bs-example'>";
  echo "<nav class='navbar navbar-expand-md navbar-dark bg-dark'>";
	echo "<a class='navbar-brand' href='#page-top'>Reiseregninger</a>";
	echo "<button type='button' class='navbar-toggler' data-toggle='collapse' data-target='#navbarCollapse'>";
	echo "<span class='navbar-toggler-icon'></span>";
	echo "</button>";
	echo "<div class='collapse navbar-collapse' id='navbarCollapse'>";
	echo "<div class='navbar-nav'>";
	echo "<a class='nav-link' href='skjema.php'>Registrer</a>";
	echo "<a class='nav-link' href='minside.php'>Min side</a>";
	echo "<a class='nav-link' href='statistikk.php'>Statistikk</a>";
	echo "</div>";
	echo "<div class='navbar-nav ml-auto'>";
	//hvis bruker er innlogget, logout knapp vises:
if (isset($_SESSION['brukernavn'])) {
            echo "<form action='logout.php' method = 'get'>
                <button class='btn btn-primary my-2 my-sm-0 navbar-btn' type='submit'><span class='glyphicon glyphicon-log-in'></span> Logg  ut</button>
            </form>";
          }
	echo "</div>";
	echo "</div>";
	echo "</nav>";
	echo "</div>";
}


//Head delen er lik for alle sider, inkluderer lenker:
Function Head() {
	  echo "<meta charset='utf-8'>";
	  echo "<meta name='viewport' content='width=device-width, initial-scale=1'>";
	  echo "<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css'>";
	  echo "<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js'></script>";
	  echo "<script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js'></script>";
	  echo "<script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js'></script>";
	  echo "<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css'>";
	  echo "<link rel='stylesheet' href='//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css'>";
	  echo "<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>";
	  echo "<link rel='stylesheet' href='css/style.css'>";
	  echo "<script src='https://code.jquery.com/jquery-1.12.4.js'></script>";
	  echo "<script src='https://code.jquery.com/ui/1.12.1/jquery-ui.js'></script>";
		echo "<script src='https://code.jquery.com/jquery-3.1.1.min.js'></script>";
		echo "<script src='https://code.highcharts.com/highcharts.js'></script>";
		echo "<script src='https://code.highcharts.com/highcharts-more.js'></script>";
		echo "<script src='https://canvasjs.com/assets/script/canvasjs.min.js'></script>";
}

Function Session() {
	//sjekker om brukeren er innlogget, hvis ikke routes til login:
	if( !isset($_SESSION['brukernavn'])) {
	  echo header("Location: login.php");
	  exit;
	}
		}

Function brukernavn() {
	if (isset($_SESSION['brukernavn'])) {
	  $brukernavn=$_SESSION['brukernavn'];
		return $brukernavn;
	}
}


?>
