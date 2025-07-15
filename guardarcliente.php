<?php

#Salir si alguno de los datos no está presente
if(
	!isset($_GET["id_venta"])
) exit();
 
 
#Si todo va bien, se ejecuta esta parte del código...

include_once "base_de_datos.php";
$id_venta = $_GET["id_venta"];
$id_cliente = $_GET["id_cliente"];
$id_cliente_nuevo = $_GET["id_cliente_nuevo"];
 
 

$sentencia = $base_de_datos->prepare("UPDATE ventastienda SET cliente = ? WHERE id = ?;");
$resultado = $sentencia->execute([$id_cliente_nuevo , $id_venta]);

if($resultado === TRUE){
	header("Location: ./verventas.php?cliente=".$id_cliente);
	//exit;
}
else echo "Algo salió mal. Por favor verifica que la tabla exista, así como el ID ";
?>