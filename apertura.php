<?php
#Salir si alguno de los datos no está presente
if(!isset($_POST["monto"]) || !isset($_POST["cajero"])) exit();
include_once "base_de_datos.php";
date_default_timezone_set("America/La_Paz");
$monto = $_POST["monto"];
$cajero = $_POST["cajero"];
$fecha = date("Y-m-d H:i:s");


$sentencia = $base_de_datos->prepare("INSERT INTO apertura(monto,cajera,fecha) VALUES (?,?, ?);");
$resultado = $sentencia->execute([$monto,$cajero, $fecha ]);

if($resultado === TRUE){
	header("Location: ./vender.php");
	exit;
}
else echo "Algo salió mal";


?>
<!-- <?php include_once "pie.php" ?> -->