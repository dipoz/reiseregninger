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
<title>Reiseskjema</title>
</head>
<body class="d-flex flex-column">
  <!--funksjon for Navbar-->
  <?php Navbar(); ?>
  <header>
    <div class="container text-center">
      <h3>Fyll ut reiseregningsskjema</h3>
    </div>
  </header>
 <!--main content:-->
  <div class="container2" id="page-content">
     <div class="row">
       <div class="col-lg-8 mx-auto">
         <form class = "form-signin"  action="reiseRegistrert.php" method="post">

        <!--Valg av dato:-->
      <div class="form-group">
        <label for="datepicker">Velg dato:</label><br>
        <input type="date" class="datepicker" name="datepicker" required>
      </div>

<!--her kan man registrere det som er nødvendig:-->
      <div class="form-group">
        <label for="destinasjon">Reisemål</label>
        <input type="text" class="form-control" name="reisemal" required>
      </div>
      <div class="form-group">
        <label for="beskrivelse">Beskrivelse</label>
        <textarea class="form-control" id="beskrivelse" name="beskrivelse" placeholder="Beskriv.." rows="3" required></textarea>
      </div>
      <div class="form-group">
        <label for="kostnad">Kostnad</label><br>
        <input type="number" min="0" max="20000.00" name="kostnad">
      </div>
      <div class="form-group">
        <label for="status">Utbetalt</label>
          <select class="form-control" id="status" name="status">
            <option value="Nei">Nei</option>
            <option value="Ja">Ja</option>
          </select>
        </div>
<!--mulighet for å laste opp fil:
<div class="form-group">
        <div class="custom-file">
    <input type="file" class="custom-file-input" id="validatedCustomFile" required>
    <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
    <div class="invalid-feedback">Example invalid custom file feedback</div>
  </div>
</div>-->
      <button type="submit" class = "btn btn-info" name="send">Lagre</button>
    </div>
  </form>
</div>
</div>

   <!-- funksjon for Footer -->
  <?php Footer(); ?>

<?php

// Databasetilkoblingen lukkes
mysqli_close ($conn);
?>
</body>
</html>
