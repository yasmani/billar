<?php
 
//id del producto
$idProducto = $_POST["codigo"];
$monto = $_POST["monto"];
 
//$categoria = isset($_POST["cantidad"])?$_POST["cantidad"]:'';
 //echo $usuario2;
include_once "base_de_datos.php";
 date_default_timezone_set("America/La_Paz");
$base_de_datos->beginTransaction();
  
 date_default_timezone_set("America/La_Paz");

$ahora = date("Y-m-d H:i:s");
$hora = date("H:i:s");

    $sentencia = $base_de_datos->prepare("UPDATE carrito SET fechaFin =  ?,precio =  ?  WHERE id = ?;");
$resultado = $sentencia->execute([$ahora,$monto,  $idProducto]);
 

$sentencia3 = $base_de_datos->prepare("DELETE FROM pausas_billar WHERE id_carrito = ?;");
      $resultado2 = $sentencia3->execute([$idProducto]);

$base_de_datos->commit();
header("Location: ./venderMesa.php?categoria=".$categoria);
