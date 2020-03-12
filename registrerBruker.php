<?php
session_start();

//tilkobling til databasen:
include "funksjoner.inc.php";
$conn = kobleTil();
?>

<?php

//sjekker om brukeren er innlogget, hvis ja, routes til minside:
if (isset($_SESSION['brukernavn'])!="") {
  header("Location:minside.php");
}

if(isset($_POST['registrer']))
{
  //mot sql injection:
  $strBrukernavn = mysqli_real_escape_string($conn, $_POST[ 'brukernavn']);
  $strFornavn = mysqli_real_escape_string($conn, $_POST[ 'fornavn']);
  $strEtternavn = mysqli_real_escape_string($conn, $_POST[ 'etternavn']);
  $strPassord = mysqli_real_escape_string($conn, $_POST[ 'passord']);


//passord blir kryptert for at det ikke lagres i databasen i klar tekst:
  $passwordHashed = password_hash($strPassord, PASSWORD_DEFAULT);


//sjekk om bruker er allerede registrert i databasen:
    $check_epost_query="SELECT * from bruker WHERE brukernavn='$strBrukernavn'";
    $run_query=mysqli_query($conn,$check_epost_query);

//hvis ikkr bruker er registrert fra før, legge inn i databasen:
    if(mysqli_num_rows($run_query)==0){

      $insert_user="insert into bruker (brukernavn,fornavn,etternavn,passord) VALUE ('$strBrukernavn','$strFornavn','$strEtternavn','$passwordHashed')";
    if(mysqli_query($conn,$insert_user))
    {

  //hvis brukeren registreres in databasen, beskjed om det og pålogginggside åpnes:
      echo "<script>alert('Gratulerer! Du kan nå logge inn.')</script>";
      echo"<script>window.open('login.php','_self')</script>";

    }
    }else{
    echo "<script>alert('Epost $strBrukernavn er allerede registrert i databasen. Vennligst logg deg inn eller velg en annen epost!')</script>";
    if(isset($_POST) & count($_POST)) { $_SESSION['post'] = $_POST; }
    if(isset($_SESSION['post']) && count($_SESSION['post'])) { $_POST = $_SESSION['post']; }
    }
}

//tilkoblingen til databasen lukkes:
mysqli_close ($conn);

?>
<!DOCTYPE html>
<html>
<head lang="no">
<link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" href="../../../../favicon.ico">
  <title>Registrering</title>
<style>
  body{padding-top:20px;}
</style>
<title>Registrering</title>
</head>
<body>
  <div class="header">
  </div>
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-success">
                <div class="panel-heading">
                  <center><h2 class="panel-title"><a href="login.php"><strong>Reiser AS</strong></a></h2></center><br>
                    <center><h3 class="panel-title">Register deg</h3></center>
                </div>

                <!--Form for registrering:-->
                <div class="panel-body">
                    <form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="Epost" name="brukernavn" type="email" required>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Fornavn" name="fornavn" type="text"required>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Etternavn" name="etternavn" type="text"required>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Passord" name="passord" type="password" value="" required>
                            </div>
                  </div>
                </div>
        <input class="btn btn-lg btn-success btn-block" type="submit" value="Registrer" name="registrer" >
      </fieldset>
      </form>
      <center><b>Allerede registrert?</b> <br></b><a href="login.php">Logg inn her</a></center><!--for centered text-->
      </div>
    </div>
  </div>
  </div>
</div>
</body>
</html>
