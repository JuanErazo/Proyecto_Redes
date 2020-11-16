<?php



#if(empty($_POST) || $_POST["sql"] == ""){
#  DIE("");

#}

#$sql = $_POST["sql"];
echo " <center><h1>Base de datos</h1></center> <br>";

#echo $sql;
$sql="SELECT fecha, humedad, temperatura, presion, altitud FROM datos";
displayTable($sql);





function displayTable($sql){

//Creamos la conexión
$server = "localhost";
$user = "root";
$pass = "";
$BD = "proyecto";
$conexion = mysqli_connect($server,$user,$pass,$BD);
//generamos la consulta
if(!$result = mysqli_query($conexion, $sql)) die();

$rawdata = array();
//guardamos en un array multidimensional todos los datos de la consulta
$i=0;

while($row = mysqli_fetch_array($result))
{
    $rawdata[$i] = $row;
    $i++;
}

$close = mysqli_close($conexion);

//DIBUJAMOS LA TABLA

echo '<table width="100%" border="1" style="text-align:center;">';
$columnas = count($rawdata[0])/2;
//echo $columnas;
$filas = count($rawdata);
//echo "<br>".$filas."<br>";

//Añadimos los titulos

for($i=1;$i<count($rawdata[0]);$i=$i+2){
   next($rawdata[0]);
   echo "<th><b>".key($rawdata[0])."</b></th>";
   next($rawdata[0]);
}

for($i=0;$i<$filas;$i++){

   echo "<tr>";
   for($j=0;$j<$columnas;$j++){
      echo "<td>".$rawdata[$i][$j]."</td>";

   }
   echo "</tr>";
}

echo '</table>';

}

?>