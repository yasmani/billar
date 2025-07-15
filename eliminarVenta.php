<?php
if(!isset($_GET["id"])) exit();
$id = $_GET["id"];
include_once "base_de_datos.php";

$base_de_datos->beginTransaction();

$productos_vendidos = $base_de_datos->query("SELECT productos_vendidos.id,productos_vendidos.id_producto,productos_vendidos.cantidad FROM `ventas`,productos_vendidos WHERE ventas.id=productos_vendidos.id_venta and ventas.id='$id';");

$p_vendidos = $productos_vendidos->fetchAll(PDO::FETCH_OBJ); 

foreach($p_vendidos as $productos){ 
	$id_producto=$productos->id_producto;
	$cantidad=$productos->cantidad; 

	$sentencia = $base_de_datos->prepare("UPDATE productos SET existencia = existencia+?  WHERE id = ?;");
	$resultado = $sentencia->execute([$cantidad, $id_producto]);

	if($resultado === TRUE){
		//header("Location: ./listar.php");
		//exit;
	}
	else echo "Algo salió mal. Por favor verifica que la tabla exista, así como el ID del producto";

 }
 $sentencia = $base_de_datos->prepare("DELETE FROM ventas WHERE id = ?;");
 $resultado = $sentencia->execute([$id]);
 
 $base_de_datos->commit();
 if($resultado === TRUE){
	 header("Location: ./imprimir_ventas.php");
	 exit;
	}
else echo "Algo salió mal";
?>