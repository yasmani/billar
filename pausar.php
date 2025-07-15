<?php
 
//id del producto
$idProducto = $_POST["id"];
 

 
include_once "base_de_datos.php";
 date_default_timezone_set("America/La_Paz");
$base_de_datos->beginTransaction();
  
$inicio=date("Y-m-d H:i:s");

    $sql = $base_de_datos->prepare("SELECT * FROM carrito WHERE id = ?;");
    $sql->execute([$idProducto]);
    $producto = $sql->fetch(PDO::FETCH_OBJ);

    $mesa= $producto->idmesa;
     $billar= $producto->idproducto;
      $carrito= $producto->id;



    $sentencia = $base_de_datos->prepare("INSERT INTO pausas_billar(id_mesa,producto,inicio,estado,id_carrito) VALUES (?,?,?,?,?);");
    $resultado = $sentencia->execute([$mesa,$billar, $inicio,1,$carrito]);
 
//echo $idProducto.' -'.$cantidad.'- '.$usuario2 .' -'.$idmesa.' -'.$precio; 

$base_de_datos->commit();
 header("Location: ./venderMesa.php?categoria=".$categoria);
