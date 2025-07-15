<?php
 
//id del producto
$idProducto = $_POST["id"];
 

 
include_once "base_de_datos.php";
 date_default_timezone_set("America/La_Paz");
$base_de_datos->beginTransaction();
  
$fin=date("Y-m-d H:i:s");

    $sql = $base_de_datos->prepare("SELECT * FROM pausas_billar WHERE id_carrito = ? and estado=1;");
    $sql->execute([$idProducto]);
    $producto = $sql->fetch(PDO::FETCH_OBJ);


      $carrito= $producto->id;


 

    $sentencia = $base_de_datos->prepare("UPDATE pausas_billar SET fin='$fin',estado = 2 WHERE id = ?;");
    $sentencia->execute([$carrito]);

$base_de_datos->commit();
 header("Location: ./venderMesa.php?categoria=".$categoria);