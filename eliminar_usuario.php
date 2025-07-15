<?php
if(!isset($_GET["id"])) exit();
$id = $_GET["id"];
include_once "base_de_datos.php";

$sentencia = $base_de_datos->prepare("UPDATE usuario SET ip = ? WHERE id = ?;");
$resultado = $sentencia->execute(['0', $id]);

if($resultado === TRUE){
	header("Location: ./usuarios.php");
	exit;
}
else echo "Algo salió mal. Por favor verifica que la tabla exista, así como el ID ";

 
?>