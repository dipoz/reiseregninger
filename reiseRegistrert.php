<?php
session_start();

//tilkobling til databasen:
include "funksjoner.inc.php";
$conn = kobleTil();

//funksjon for sessions:
Session();
$brukernavn = brukernavn();

?>
<!DOCTYPE html>
<html lang="no">
<head>
<!--funksjon for Head-->
<?php Head(); ?>
<title>Reise registrert</title>
</head>
<body class="d-flex flex-column">
  <!-- inkluderer funksjon for navbar -->
  <?php Navbar(); ?>
  <header>
  </header>
 <!-- main content:-->
 <div class="container2" id="page-content">
   <div class="container">
     <div class="row">
       <div class="col-lg-8 mx-auto">
         <?php

// registrerer reiseregning i databasen:
    if(isset($_POST['send']))

 //konverterer dato til riktig format:
  $datepicker = $_POST['datepicker'];
  $beskrivelse = mysqli_real_escape_string($conn, $_POST[ 'beskrivelse']);
  $reisemal=mysqli_real_escape_string($conn, $_POST['reisemal']);
  $kostnad=$_POST['kostnad'];
  $brukernavn=$_SESSION['brukernavn'];
  $status=$_POST['status'];
//når bruker vil slette reiser fremover, blir ikke de slettet, men vil få status 'slettet'
//når en reise registreres i databasen, får den status 'aktiv' som ved sletting blir til 'slettet'
  $slettet = 'aktiv';
  {

   $sql = "INSERT INTO reise (dato,brukernavn,reisemal,beskrivelse,kostnad,status,slettet) value ('$datepicker','$brukernavn','$reisemal','$beskrivelse','$kostnad','$status','$slettet')";

   if(mysqli_query($conn,$sql))

   {
     echo "<br>";
     echo "Reiseregningen din er registrert!";}
     else {
       echo "Oops, noe gikk galt!<br>";
     }
   }
   ?>
   <div class="container2">
     <br>
     <p><a href="minside.php" class="btn btn-primary btn-sm">Til min side</a></p>
   </div>
 </div>
</div>
</div>
</div>

   <!-- Funksjon for Footer -->
  <?php Footer(); ?>
<?php

// Databasetilkoblingen lukkes
mysqli_close ($conn);
?>
</body>
</html>
