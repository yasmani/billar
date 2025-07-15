<?php
 
//id del producto
$idProducto = $_POST["codigo"];
$monto = $_POST["monto"];
$inicio = $_POST["inicio"];
 
//$categoria = isset($_POST["cantidad"])?$_POST["cantidad"]:'';
 //echo $usuario2;
include_once "base_de_datos.php";
 date_default_timezone_set("America/La_Paz");
$base_de_datos->beginTransaction();
  
 date_default_timezone_set("America/La_Paz");
echo $inicio;
$ahora = strtotime ( '+ '.$monto.' hour' , strtotime ($inicio) ) ; 
$nuevafecha = date('Y-m-d H:i:s' , $ahora);

$hora = date("H:i:s");
echo 'monto:'.$monto;
echo 'ahora:'.$nuevafecha;
    // $sentencia = $base_de_datos->prepare("UPDATE carrito SET fechaFin =  ?,precio =  ?,cantidad =  ?  WHERE id = ?;");
    $sentencia = $base_de_datos->prepare("UPDATE carrito SET  precio =  ?  WHERE id = ?;");
// $resultado = $sentencia->execute([$nuevafecha, '16',$monto,  $idProducto]);
$resultado = $sentencia->execute([ $monto,   $idProducto]);
 
//echo $idProducto.' -'.$cantidad.'- '.$usuario2 .' -'.$idmesa.' -'.$precio; 

$base_de_datos->commit();
 header("Location: ./venderMesa.php?categoria=".$categoria);
