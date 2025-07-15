<?php

 
 
#Si todo va bien, se ejecuta esta parte del código...

include_once "base_de_datos.php";
$actual = $_GET["actual"];
$destino = $_GET["mesa"];
 

$sentencia = $base_de_datos->prepare("UPDATE carrito SET idmesa = ?  WHERE idmesa = ?;");
$resultado = $sentencia->execute([$destino,  $actual]);
echo "a".$actual." - ".$destino;
if($resultado === TRUE){
	header("Location: ./mesas.php");
	exit;
}
else echo "Algo salió mal. Por favor verifica que la tabla exista, así como el ID ";
?>