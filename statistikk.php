<?php
session_start();

//tilkobling til databasen:
include "funksjoner.inc.php";
$conn = kobleTil();
$kostnader=array();

//funskjon for sessions:
Session();
$brukernavn = brukernavn();

?>
<!DOCTYPE html>
<html lang="no">
<head>

  <!--funskjon for Head-->
<?php Head(); ?>
<title>Statistikk</title>
<!--egen style for statistikkside:-->
<style>
#row1 {
  padding-left: 80px;
}
</style>

</head>
<body class="d-flex flex-column">
  <!--funksjon for Navbar:-->
  <?php Navbar(); ?>
<header class="header">
  <div class="container text-center">
    <h3>Statistikk for dine reiser i siste 12 månedene <?php echo $brukernavn ?></h3>
  </div>
</header>
 <!--main content:-->
 <div class="container2">
   <div class="row">
     <div class="col-md-10" id="row1">
       <figure class="highcharts-figure">
         <div id="chartContainer" style="height: 300px; width: 100%;"></div>
      </figure>
    </div>
    <div class="col-md-2"></div></div>
    <div class="row">
      <div class="col-md-8" id="row1">
        <table class= 'table table-hover'>
          <thead class="thead-dark">
            <tr>
              <th>Måned</th>
              <th class='status'>Kostnad</th>
            </tr>
          </thead>
          <?php

          $sql = "SELECT * FROM reise where brukernavn = '$brukernavn' and slettet ='aktiv'";
          $resultat = mysqli_query($conn, $sql);

            //Legger inn måneder i array:
          $months = array(
            'Januar',
            'Februar',
            'Mars',
            'April',
            'Mai',
            'Juni',
            'Juli ',
            'August',
            'September',
            'Oktober',
            'November',
            'Desember',
          );

          $y = date('Y');
          $m = date('m');

//Lager sql spørring for å hente alle kostnader for siste 12 måneder:
    for ($i = 0; $i < 12; $i++) {
        $sql = "SELECT * from reise where brukernavn = '$brukernavn' and slettet ='aktiv' and YEAR(dato) = $y AND MONTH(dato) = $m";
        $resultat = mysqli_query($conn, $sql);

        $sum = 0;
        while ( $rad = mysqli_fetch_array($resultat) ) {

        $cost = $rad['kostnad'];
        $sum = $sum + $cost;

      }

        $month = $months[$m-1];
        $m = $m - 1;
        if($m == 0){
        $m = 12;
        //$y = $y - 1;
      }
      $kostnader[] = $sum;

      echo "<tr>";
      echo "<td>$month $y</td>";
      echo "<td class='status'>$sum</td>";
      echo "</tr>";
      }

    //Matrise for grafen:
      $dataPoints = array(
        array("label"=> $months[0], "y"=> $kostnader[11]),
        array("label"=> $months[1], "y"=> $kostnader[10]),
        array("label"=> $months[2], "y"=> $kostnader[9]),
        array("label"=> $months[3], "y"=> $kostnader[8]),
        array("label"=> $months[4], "y"=> $kostnader[7]),
        array("label"=> $months[5], "y"=> $kostnader[6]),
        array("label"=> $months[6], "y"=> $kostnader[5]),
        array("label"=> $months[7], "y"=> $kostnader[4]),
        array("label"=> $months[8], "y"=> $kostnader[3]),
        array("label"=> $months[9], "y"=> $kostnader[2]),
        array("label"=> $months[10], "y"=> $kostnader[1]),
        array("label"=> $months[11], "y"=> $kostnader[0])
);
?>

      </table>
    </div>
  </div>
</div>


   <!-- funksjon for Footer -->
  <?php Footer(); ?>
<?php
// Databasetilkoblingen lukkes
mysqli_close ($conn);
?>
</body>
<script>

//grafen:


            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                theme: "dark2",
                title:{
                    text: "Kostnader pr måned"
                },
                axisY: {
                    title: "Kroner",
                    titleFontColor: "#4F81BC",
                    lineColor: "#4F81BC",
                    labelFontColor: "#4F81BC",
                    tickColor: "#4F81BC"

                },

                toolTip: {
                    shared: true
                },
                legend: {
                    cursor:"pointer",
                    itemclick: toggleDataSeries
                },
                data: [{
                    type: "column",
                    name: "Kostnader",
                    legendText: "Kostnader",
                    showInLegend: true,
                    dataPoints:<?php echo json_encode($dataPoints,
                            JSON_NUMERIC_CHECK); ?>
                          },
              ]
          });
          chart.render();

          function toggleDataSeries(e) {
              if (typeof(e.dataSeries.visible) === "undefined"
                          || e.dataSeries.visible) {
                  e.dataSeries.visible = false;
              }
              else {
                  e.dataSeries.visible = true;
              }
              chart.render();
          }
</script>
</html>
