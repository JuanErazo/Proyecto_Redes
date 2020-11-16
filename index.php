<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" >
<head runat="server">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Medidor Temperatura, Humedad</title>

     <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <!-- -->

      <script  src="js/bootstrap.min.js"></script>
    <!-- -->
    
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
     <script type="text/javascript">
      google.charts.load('current', {'packages':['gauge']});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['Humedad', 0],
          ['Temperatura', 0]
         
        ]);

        var options = {
          width: 400, height: 400,
          redFrom: 90, redTo: 100,
          yellowFrom:75, yellowTo: 90,
          minorTicks: 5
        };

        var chart = new google.visualization.Gauge(document.getElementById('Medidores'));

        chart.draw(data, options);

        setInterval(function() {
            var JSON=$.ajax({
                url:"http://localhost/redes/DatoSensores.php?q=1",
                dataType: 'json',
                async: false}).responseText;
            var Respuesta=jQuery.parseJSON(JSON);
            
          data.setValue(0, 1,Respuesta[0].humedad);
          data.setValue(1, 1,Respuesta[0].temperatura);
          chart.draw(data, options);
        }, 1300);
        
      }
    </script>
<!--Codigo para graficar -->
     <script type="text/javascript">
      google.charts.load('current', {'packages':['gauge']});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['Presion', 0],
          ['Altitud', 0]
         
        ]);

        var options = {
          width: 400, height: 400,
          redFrom: 90, redTo: 100,
          yellowFrom:75, yellowTo: 90,
          minorTicks: 5
        };

        var chart = new google.visualization.Gauge(document.getElementById('Medidores2'));

        chart.draw(data, options);

        setInterval(function() {
            var JSON=$.ajax({
                url:"http://localhost/redes/DatoSensores2.php?q=1",
                dataType: 'json',
                async: false}).responseText;
            var Respuesta=jQuery.parseJSON(JSON);
            
          data.setValue(0, 1,Respuesta[0].presion);
          data.setValue(1, 1,Respuesta[0].altitud);
          chart.draw(data, options);
        }, 1300);
        
      }
    </script>

    <style>
        .slider{

            background: url("img/slider.png");
            background-size: cover;
            background-position: center;
            height: 400px;
        }
    </style>

  
<!-- fin de codigo par graficar-->
  </head>
  <body>

  <!--Menu -->
  <div class="container-fluid  bg-dark fixed-top">
    <nav class="navbar navbar-expand-lg navbar-light bg-light navbar-dark bg-dark container">
   <a class="navbar-brand" href="#">
    <img src="img/icon.png" width="30" height="30" class="d-inline-block align-top" alt="" loading="lazy">
    Aunar
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">

    <div class="navbar-nav ml-auto">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
        <a class="nav-link" href="#">Acerca <span class="sr-only">(current)</span></a>
      </li>
      </ul>
    </div>
  </div>
</nav>
  </div>
  <!--fin Menu -->
  <!--slider -->

    <div class="container-fluid slider d-flex justify-content-center item align-items-center">
      <div  class="text-center text-white">
        <h3> Internet de las cosas</h3>
        <h1 class="display">Estacion Meteriologica</h1>
        <p class="lead"> Juan Erazo - Eber Nasner  </p>
      </div>

    </div>

  <!--fin slider -->
  <!--main -->
  <main>
    <div class="container"> 
      <center><h3>IOT</h3></center>
      
      <p class="lead">Temperatura - Humedad</p>
      <hr>
      <center>
      <div id="Medidores" ></div>
      </center>
    </div>

     <div class="container"> 

      
      <p class="lead"> Presion - Altitud </p>
      <hr>
        <center>
      <div id="Medidores2" ></div>
      </center>
   
    </div>

     <div class="container"> 

      
      <p class="lead"> Tablas </p>
      <hr>
        <center>

            <a class="btn btn-primary btn-block btn btn-dark" href="tablas.php" role="button">Datos</a>
   
      </center>
      <hr>
    </div>

  
  </main>

  <!--fin main-->

  <footer class="container-fluid bg-dark text-white py-3 text-center">
    
    <p>DISEÑO E IMPLEMENTACIÓN DE REDES DE DATOS
  </p>

  </footer>
  


  </body>
</html>