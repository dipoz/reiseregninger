<?php
session_start();

//tilkobling til databasen:
include "funksjoner.inc.php";
$conn = kobleTil();

Session(); //funksjon for session
$brukernavn = brukernavn();

?>
<!DOCTYPE html>
<html lang="no">
<head>

<!--funksjon for Head:-->
<?php Head(); ?>
<title>Registrer endringer</title>
</head>
<body class="d-flex flex-column">
<!-- inkluderer funksjon for navbar -->
<?php Navbar(); ?>
<header>
</header>

 <!--main content:-->
  <div class="container2" id="page-content">
   <div class="container">
     <?php if (isset($_POST['save'])) {
    $beskrivelse = mysqli_real_escape_string($conn, $_POST[ 'beskrivelse']);
    $reisemal = mysqli_real_escape_string($conn, $_POST['reisemal']);
    $date=$_POST['datepicker'];
    $sql = "UPDATE reise SET dato = '$date', reisemal='" . $reisemal . "',beskrivelse='" . $beskrivelse . "',kostnad='" . $_POST['kostnad'] . "',status='" . $_POST['status'] . "',slettet = 'aktiv' where reise_id = '" . $_POST['reise_id'] . "'";
    $resultat = $conn->query($sql);
  //test for å sjekke sql spørring:
    //echo $sql;
    if ($resultat) {
      echo "<br>";
      echo "Endringer er lagret!";
    } else {
      echo "Noe gikk galt!";
      }
    }

 ?>
 <div class="container2"><br>
   <!--Når endring er registrert, kan man velge navigering til minside:-->
 <p><a href="minside.php" class="btn btn-primary btn-sm">Til min side</a></p>
 </div>
</div>
</div>
   <!-- fuknsjon for Footer -->
  <?php Footer(); ?>
<?php

// Databasetilkoblingen lukkes
mysqli_close ($conn);
?>
</body>
</html>
