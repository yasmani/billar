<?php
if(!isset($_GET["id"])) exit();
$id = $_GET["id"];
include_once "base_de_datos.php";
$sentencia = $base_de_datos->prepare("DELETE FROM carrito WHERE id = ?;");
$resultado = $sentencia->execute([$id]);
echo $id;
if($resultado === TRUE){
 	header("Location: ./venderMesa.php");
 	exit;
}
else echo "Algo salió mal";
?>