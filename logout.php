<?php
session_start();
//Sesjon til innlogget bruker avsluttes / Utlogging

unset($_SESSION["brukernavn"]);

// til innloggingssiden
header("Location:login.php");
?>
