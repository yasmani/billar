<?php
if(!isset($_GET["id"])) exit();
$id = $_GET["id"];
include_once "base_de_datos.php";
 echo $id;
$base_de_datos->beginTransaction();
  

// foreach($p_vendidos as $productos){ 
// 	$id_producto=$productos->id_producto;
// 	$cantidad=$productos->cantidad; 

// // 	$sentencia = $base_de_datos->prepare("UPDATE productos SET tienda = tienda+?  WHERE id = ?;");
// // 	$resultado = $sentencia->execute([$cantidad, $id_producto]);

// 	if($resultado === TRUE){
// 		//header("Location: ./listar.php");
// 		//exit;
// 	}
// 	else echo "Algo salió mal. Por favor verifica que la tabla exista, así como el ID del producto";

//  }
//  $sentencia = $base_de_datos->prepare("DELETE FROM ventastienda WHERE id = ?;");
//  $resultado = $sentencia->execute([$id]);
 
  	$sentencia = $base_de_datos->prepare("UPDATE ventastienda SET entregado = 1  WHERE id = ?;");
	$resultado = $sentencia->execute([$id]);
//;
 $base_de_datos->commit();
 if($resultado === TRUE){
	 header("Location: ./imprimir_ventas_tienda2.php");
	 exit;
	}
else echo "Algo salió mal";
?>