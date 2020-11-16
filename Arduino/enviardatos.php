<?php
$conexion = mysqli_connect("localhost", "root", "",'proyecto');
mysqli_query($conexion,"SET NAMES 'utf8'");

$chipid = $_POST ['chipid'];
$humedad = $_POST ['humedad'];
$temperatura = $_POST ['temperatura'];
$presion = $_POST ['presion'];
$altitud = $_POST ['altitud'];


mysqli_query($conexion,"INSERT INTO `proyecto`.`datos` (`id`, `chipId`, `fecha`, `humedad`,`temperatura`,`presion`,`altitud`) VALUES (NULL, '$chipid', CURRENT_TIMESTAMP, '$humedad', '$temperatura', '$presion', '$altitud');");

mysqli_close($conexion);

echo "Datos ingresados correctamente.";
?>