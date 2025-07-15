<?php
if(!isset($_GET["id"])) exit();
$id = $_GET["id"];
include_once "base_de_datos.php";

$base_de_datos->beginTransaction();

$productos_vendidos_tienda = $base_de_datos->query("SELECT productos_vendidos_tienda.id,productos_vendidos_tienda.id_producto,productos_vendidos_tienda.cantidad FROM `ventastienda`,productos_vendidos_tienda WHERE ventastienda.id=productos_vendidos_tienda.id_venta and ventastienda.id='$id';");

$p_vendidos = $productos_vendidos_tienda->fetchAll(PDO::FETCH_OBJ); 

foreach($p_vendidos as $productos){ 
	$id_producto=$productos->id_producto;
	$cantidad=$productos->cantidad; 

	$sentencia = $base_de_datos->prepare("UPDATE productos SET tienda = tienda+?  WHERE id = ?;");
	$resultado = $sentencia->execute([$cantidad, $id_producto]);

	if($resultado === TRUE){
		//header("Location: ./listar.php");
		//exit;
	}
	else echo "Algo salió mal. Por favor verifica que la tabla exista, así como el ID del producto";

 }
 $sentencia = $base_de_datos->prepare("DELETE FROM ventastienda WHERE id = ?;");
 $resultado = $sentencia->execute([$id]);
 
 $base_de_datos->commit();
 if($resultado === TRUE){
	 header("Location: ./ventaseliminado.php");
	 exit;
	}
else echo "Algo salió mal";
?>