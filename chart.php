<?php 
session_start();
include_once "encabezado.php";
include_once "base_de_datos.php";

$ahora = date("Y-m-d H:i:s");
date_default_timezone_set("America/La_Paz");
$sentencia = $base_de_datos->query("SELECT * from ventas");
$ventas = $sentencia->fetchAll(PDO::FETCH_OBJ);

foreach($ventas as $venta){ 

}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Ventas </title>
	<link rel="stylesheet" href="./css/fontawesome-all.min.css">
	<link rel="stylesheet" href="./css/2.css">
	<link rel="stylesheet" href="./css/estilo.css">
	 <link rel="stylesheet" href="jss/bootstrap.min.css">
  <script src="jss/jquery.min.js"></script>
  <!--<script src="jss/bootstrap.min.js"></script>-->
</head>
<body style="background-color:#28293B ;color:white">
	</body>
	</html>
<?php include_once "pie.php" ?>