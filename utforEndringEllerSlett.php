<?php
session_start();

//tilkobling til databasen:
include "funksjoner.inc.php";
$conn = kobleTil();
Session();
$brukernavn = brukernavn();

?>
<!DOCTYPE html>
<html lang="no">
<head>
<!--funksjon for Head-->
<?php Head(); ?>
<title>Utfør handling</title>
</head>
<body class="d-flex flex-column">
  <!-- inkluderer funksjon for navbar -->
<?php Navbar(); ?>
<header>
</header>
 <!--main content:-->
  <div class="container2" id="page-content">
   <div class="container">
     <div class="row">
       <div class="col-lg-8 mx-auto">


<?php
//Hvis knapp slett er trykket for reisen på minside:
if (isset($_POST['slett'])) {
  //sletter ikke fra databasen, men registrerer som slettet (med status slettet) i databasen. Dette kan selvsagt endres for
  //å slette helt fra databasen, men jeg velger å beholde slettede elementer i databasen i denne løsningen.
  //Viktig at korrekt reise blir slettet, derfor bruker jeg reise_id:
  $sql = "UPDATE reise SET slettet = 'slettet' where reise_id = '" . $_POST['reise_id'] . "'";
  $resultat = $conn->query($sql);
  echo "<br>";
  echo "<p>Reisen er slettet<p>";
  echo "<div class='container2'>";
  echo "<br>";
  echo "<p><a href='minside.php' class='btn btn-primary btn-sm'>Til min side</a></p>";
  echo "</div>";
  echo "</div>";
  echo "</div>";

//hvis knapp endre er trykket for reisen på minside:
} elseif  (isset($_POST['endre'])) {

  //Vis skjema og sette inn eksisterende verdier for reisen:
  echo "<h2>Endring av reise</h2>";
  //Henter ut riktig reise først:
  $sql = "SELECT * from reise where reise_id = '" . $_POST['reise_id'] . "'";
  $resultat = $conn->query($sql);
  $rad = $resultat->fetch_assoc();
  $reise_id=$rad['reise_id'];

//Lagrer verdier for status inn i matrise:
$statusOptions = array('Ja','Nei')?>

<form action="endringRegistrert.php" method = "post">
        <!--Valg av dato:-->
  <div class="form-group">
    <input name='reise_id' hidden value = <?php echo $reise_id ?> />
      <label for="datepicker">Velg dato:</label><br>
      <input type="date" name="datepicker" class="datepicker" value="<?php echo $rad['dato']; ?>">
  </div>

<!--her kan man registrere det som er nødvendig:-->
  <div class="form-group">
    <label for="destinasjon">Reisemål</label>
    <input type="text" class="form-control" name="reisemal" required value="<?php echo $rad['reisemal'] ?>">
      </div>
      <div class="form-group">
        <label for="beskrivelse">Beskrivelse</label>
        <textarea class="form-control" id="beskrivelse" name="beskrivelse" placeholder="Beskriv.." rows="3" required><?php echo $rad['beskrivelse'] ?></textarea>
      </div>
      <div class="form-group">
        <label for="kostnad">Kostnad</label><br>
        <input type="number" min="0" max="20000.00" name="kostnad" value="<?php echo $rad['kostnad'] ?>">
      </div>
      <div class="form-group">
        <label for="status">Utbetalt</label>
          <select class="form-control" id="status" name="status">
            <?php foreach ($statusOptions AS $opt) {
              echo '<option value="' . $opt . '"' . ($rad["status"] == $opt ? ' selected="selected"' : '') . '>' . $opt . '</option>';
            } ?>
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
<input type = "submit" name="save" class = "btn btn-info" value="Lagre"/>
</div>
</form>
<?php } ?>
</div>
</div>
</div>
   <!-- funksjon for Footer -->
  <?php Footer(); ?>

<?php

// Databasetilkoblingen lukkes
mysqli_close ($conn);
?>

<script>
</script>
</body>
</html>
