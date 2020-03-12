<?php
session_start();

//tilkobling til databasen:
include "funksjoner.inc.php";
$conn = kobleTil();

//sjekker om brukeren er innlogget, hvis ja, routes til minside:
if (isset($_SESSION['brukernavn'])!="") {
  header("Location:minside.php");
}

//hvis knappen login er trykket:
if(isset($_POST['login']))
{
  //mot sql injection:
  $brukernavn = mysqli_real_escape_string($conn, $_POST[ 'brukernavn']);
  $passord = mysqli_real_escape_string($conn, $_POST[ 'passord']);
  //sjekker om brukeren er registrert i databasen:
  $check_user = $conn->query("select brukernavn, passord from bruker WHERE brukernavn='$brukernavn'");
    //$result = $conn->query($check_user);
  $rad = $check_user->fetch_array();
  $count = $query->num_rows;

      //hvis passordet stemmer, SESSION opprettes og minside.php åpnes:
      //passordet er kryptert, det må verifiseres først
  $verify = password_verify($passord, $rad['passord']);
  if($verify){
          $_SESSION['brukernavn']=$brukernavn;
          header("Location: minside.php");
      }else{
          echo "<script>alert('Epost eller passord er feil!')</script>";
      }
}
mysqli_close ($conn);

?>
<!DOCTYPE html>
<html lang="no">
<head>
<title>Logg inn</title>
  <!-- egne css og script for påloggingsside -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" href="../../../../favicon.ico">

  <style>
  <?php include 'css/style.css'; ?>
  body{padding-top:20px;}
  </style>
</head>
<body>

<!--innloggingsskjema:-->
  <div class="container">
      <div class="row">
          <div class="col-md-4 col-md-offset-4">
              <div class="login-panel panel panel-success">
                  <div class="panel-heading">
                  <center><h2 class="panel-title"><a href="login.php"><strong>Reiser AS</strong></a></h2><br></center>
                  <center><h3 class="panel-title">Logg inn</h3></center>
                  </div>
                  <div class="panel-body">
                      <form role="form" method="post" action="login.php">
                          <fieldset>
                              <div class="form-group"  >
                                  <input class="form-control" placeholder="Epost adresse" name="brukernavn">
                              </div>
                              <div class="form-group">
                                  <input class="form-control" placeholder="Passord" name="passord" type="password" value="">
                              </div>
                              <input class="btn btn-lg btn-success btn-block" type="submit" value="Logg inn" name="login" >
                          </fieldset>
                      </form>

                      <!--man kan gå til registrering:-->
                      <center><b>Vil registrere deg?</b> <br></b><a href="registrerBruker.php">Registrer deg her</a></center>
                  </div>
              </div>
          </div>
      </div>
  </div>
  </body>
  </html>
