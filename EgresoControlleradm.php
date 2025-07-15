<?php
#Salir si alguno de los datos no está presente
if(!isset($_POST["nombre"]) || !isset($_POST["cantidad"]) || !isset($_POST["detalle"]) || !isset($_POST["total"])) exit();

#Si todo va bien, se ejecuta esta parte del código...

include_once "base_de_datos.php";
date_default_timezone_set("America/La_Paz");
$nombre = $_POST["nombre"];
$usuario = $_POST["usuario"];
$cantidad = $_POST["cantidad"];
$descripcion = $_POST["detalle"];
$total = $_POST["total"];
$fecha = date('Y-m-d');
echo $nombre."\n";
echo $cantidad;
echo $descripcion;
echo $total;
echo $fecha;

$sentencia = $base_de_datos->prepare("INSERT INTO egresosadm(nombre,cantidad, detalle, total, fecha,condicion,usuario) VALUES (?,?, ?, ?,?, ?,?);");
$resultado = $sentencia->execute([$nombre,$cantidad, $descripcion, $total,$fecha,0,$usuario]);

if($resultado === TRUE){
	header("Location: ./egresoadm.php");
	exit;
}
else echo "Algo salió mal. Por favor verifica que la tabla exista";


?>
<!-- <?php include_once "pie.php" ?> -->