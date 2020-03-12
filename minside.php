<?php
session_start(); //starte brukersesjon

include "funksjoner.inc.php"; //inkludere funksjoner:
$conn = kobleTil(); //funksjon for å koble til databasen

//funksjon for sessions:
Session();
$brukernavn = brukernavn();
?>

<!DOCTYPE html>
<html lang="no">
<head>
  <!--inkluderer head.php som er lik for alle sider:-->
<?php Head(); ?>
<title>Min side</title>
</head>
<body class="d-flex flex-column">
  <!--funksjon for navbar-->
<?php Navbar(); ?>

<!--header:-->
<header class="header">
  <div class="container text-center">
    <h3>Dine reiseregninger <?php echo $brukernavn ?></h3>
  </div>
</header>

 <!--main content:-->
<div class="container" id="page-content">
  <div class="container">
<?php
//Lager sql spørring for å hente alle kostnader som tilhører bruker og ikke er slettet:
$sql2 = "SELECT kostnad, status from reise where brukernavn = '$brukernavn' and slettet ='aktiv'";
$resultat2 = mysqli_query($conn, $sql2);
if ($resultat2)
{
  //Definerer matriser for å beregne totale kostnader:
  $kostnad = array(); //kostnader
  $betalt = array(); //utbetalte kostnader
  $utestaende = array(); //ikke utbetalte kostnader

while ($row = $resultat2->fetch_assoc()) {
  $kostnad[] = $row['kostnad'];
  //bruker innebygd funksjon array_sum for å beregne totale kostnader:
  $totalt=array_sum($kostnad);

  if ($row['status'] == 'Ja') { //reiser som er utbetalt har status Ja i databasen
    $betalt[] = $row['kostnad'];
    //bruker innebygd funksjon array_sum for å beregne utbetalte kostnader:
    $utbetaltTotalt = array_sum($betalt);
    //teller antall rader for utbetalte kostnader (hvis > 0, skal utbetalte kostnader vises, hvis <0, skal 0 vises)
    $antallUtbetalt +=1;
  }
  if ($row['status'] == 'Nei') {//reiser som ikke er utbetalt har status Nei i databasen
    $utestaende[] = $row['kostnad'];
    //bruker innebygd funksjon array_sum for å beregne utestående kostnader:
    $utestaendeTotalt=array_sum($utestaende);
    //teller antall rader for utestående kostnader (hvis > 0, skal utestående kostnader vises, hvis <0, skal 0 vises)
    $antallUtestaende +=1;
  }
  }

//beregner antall reser som er lik med antall rader i matrise:
  $antallReiser=mysqli_num_rows($resultat2);
  if ($antallReiser>'0') {
  $gjennomsnitt=finnGjennomsnitt($totalt, $antallReiser); } else { //finner gjennomsnitt pr reise ved hjelp av funsjon
  $gjennomsnitt = '0'; }

} else {
  //feilmelding hvis ingen resultat fra databasen vises:
  echo "Noe gikk galt!";
}
?>
<!--tabell for å vise antall kostnader, gjennomsnitt pr reise, utbetalt og utestående beløp:-->
  <div class="table-responsive">
    <table class="table1" style="width:100%" >
      <tr class="table-info">
        <th class='status'>Totale kostnader:</th>
        <th class='status'>Gjennomsnittlig per reise: </th>
        <th class='status'>Utbetalt:</th>
        <th class='status'>Utestående beløp:</th>
      </tr>
      <tr>
      <!--hvis beløp er 0, skal det vises 0-->
        <td class='status'><?php if ($totalt > '0') {echo $totalt . " kroner"; } else {echo "0 kroner";}?></td>
        <td class='status'><?php if ($gjennomsnitt > '0') {echo $gjennomsnitt . " kroner"; } else {echo "0 kroner";}?></td>
        <td class='status'><?php if ($antallUtbetalt > '0') { echo $utbetaltTotalt . " kroner"; } else { echo "0 kroner";}?></td>
        <td class='status'><?php if ($antallUtestaende > '0') { echo $utestaendeTotalt . " kroner"; } else { echo "0 kroner";}?></td>
      </tr>
    </table>
  </div>

  <div class="container2">
    <div class="row">
       <!--lager filter for å filtrere etter reisemål:-->
       <section class="container"><i class="fa fa-filter"></i>
         <?php $sql2 = "SELECT distinct reisemal, slettet from reise where brukernavn = '$brukernavn' and slettet = 'aktiv'";
         $result2 = mysqli_query($conn, $sql2);
         ?>

         <select id="select" type="search" class="table-filter" data-table="table">
           <option value="">Reisemål</option>
           <?php while($row2 = mysqli_fetch_array($result2))
           {?>
            <option><?php echo $row2['reisemal'];?></option>
        <?php  } ?>

       </select>
       <!--tabell for å vises reiser som er lagret i databasen-->
       <div class="table-responsive" id="table2">
         <table class="table table-hover" style="width:100%" >
           <thead class="thead-dark">
             <tr>
               <th></th>
               <th class='status'>Dato</th>
               <th>Reisemål</th>
               <th>Kommentar</th>
               <th class='status'>Kostnad</th>
               <th class='status'>Betalt</th>
               <th></th>
             </tr>
           </thead>
           <?php

           //velger alle reiser som er registrert på bruker og ikke er slettet fra databasen:
           $sql = "SELECT * from reise where brukernavn = '$brukernavn' and slettet = 'aktiv' order by dato DESC, reise_id DESC";
           $resultat = $conn->query($sql);
           //viser en og en reise
           $antall = $resultat->num_rows;
           for ($i = 0; $i<$antall; $i++) {
             $rad = $resultat->fetch_assoc();
             $reise_id=$rad['reise_id'];
             $status=$rad['status'];
             ?>

             <?php
             echo "<form action='utforEndringEllerSlett.php' method='post'>";
             echo "<tbody>";
             echo "<tr>";
             echo "<input name='reise_id' hidden value = $reise_id />"; //skjult input for å notere reise id
             echo "<td><button type = 'submit' name='endre' class = 'btn btn-info'>Endre</button></td>"; //knapp for å gjøre endringer
             echo "<td class='status'>{$rad['dato']}</td>"; //starter en ny rad
             echo "<td>{$rad['reisemal']}</td>";
             echo "<td>{$rad['beskrivelse']}</td>";
             echo "<td class='status'>{$rad['kostnad']}</td>";
             //forskjellige farger avhengig om kostnad er utbetalt eller ikke:
             if ($status=='Nei') {
               echo "<td class='status' style='background-color:red;color:white;'>{$rad['status']}</td>";
             } else {
               echo "<td class='status' style='background-color:yellowgreen;color:white;'>{$rad['status']}</td>";
             } ?>
             <!--Lager infovindu for å spørre bruker om han/hun virkelig ønsker å slette:-->
             <td><a href="utfor.php" onClick="return confirm('Er du sikker på at du vil slette reise til <?php echo $rad['reisemal']?>? Dette kan ikke omgjøres.');">
               <!--knapp for å slette reise:-->
               <button type = "submit" name="slett" class = "btn btn-danger">Slett</button></a>
             </td>
           </tr>
         </tbody>
       </form>
     <?php }
//melding vises hvis ikke er det registrert noe reiser:
if ($antall ==0) {
  echo "<p>Ingen reiser registrert</p>";
  }
  echo "</table>";
  ?>
  </div>
  </section>
  </div>
  </div>
  </div>
  </div>
   <!-- funksjon for footer -->
  <?php Footer(); ?>
  <?php

  // Databasetilkoblingen lukkes
  mysqli_close ($conn);
  ?>
</body>
<script>
//filter for reisemål:
(function(document) {
	'use strict';
	var LightTableFilter = (function(Arr) {
    var _select;
		function _onSelectEvent(e) {
			_select = e.target;
			var tables = document.getElementsByClassName(_select.getAttribute('data-table'));
			Arr.forEach.call(tables, function(table) {
				Arr.forEach.call(table.tBodies, function(tbody) {
					Arr.forEach.call(tbody.rows, _filterSelect);
				});
			});
		}
		function _filterSelect(row) {
			var text_select = row.textContent.toLowerCase(), val_select = _select.options[_select.selectedIndex].value.toLowerCase();
			row.style.display = text_select.indexOf(val_select) === -1 ? 'none' : 'table-row';
		}
		return {
			init: function() {
				var selects = document.getElementsByClassName('table-filter');
				Arr.forEach.call(selects, function(select) {
         select.onchange  = _onSelectEvent;
				});
			}
		};
	})(Array.prototype);

	document.addEventListener('readystatechange', function() {
		if (document.readyState === 'complete') {
			LightTableFilter.init();
		}
	});

})(document);
</script>
</html>
