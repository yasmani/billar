<?php
#Salir si alguno de los datos no está presente
if(!isset($_POST["nombre"]) || !isset($_POST["telefono"])) exit();
include_once "base_de_datos.php";
date_default_timezone_set("America/La_Paz");
$nombre = $_POST["nombre"];
$telefono = $_POST["telefono"];
$fecha = date("Y-m-d");

echo "nombre ".$nombre." telefono".$telefono." fecha ".$fecha;
//INSERT INTO `cliente` (`id`, `nombre`, `telefono`) VALUES (NULL, 'willian', '61599811');
$sentencia = $base_de_datos->prepare("INSERT INTO `cliente` (`id`, `nombre`, `telefono`, `fecha`) VALUES (?,?,?,?);");
$resultado = $sentencia->execute([NULL,$nombre,$telefono, $fecha ]);

if($resultado === TRUE){
	header("Location: ./vender.php");
	exit;
}
else echo "Algo salió mal";


?>
<!-- <?php include_once "pie.php" ?> -->