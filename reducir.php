<?php
 
//id del producto
$idcarrito = $_POST["id"];
 $cantidad = $_POST["cantidad"];
 $descontar = $_POST["descontar"];
 $idproducto = $_POST["idproducto"];
 $categoria = $_GET["categoria"];
// $inicio = $_POST["inicio"];
 
//$categoria = isset($_POST["cantidad"])?$_POST["cantidad"]:'';
 //echo $usuario2;
include_once "base_de_datos.php";
 date_default_timezone_set("America/La_Paz");
$base_de_datos->beginTransaction();
  
//  date_default_timezone_set("America/La_Paz");
// echo $inicio;
// $ahora = strtotime ( '+ '.$monto.' hour' , strtotime ($inicio) ) ; 
// $nuevafecha = date('Y-m-d H:i:s' , $ahora);

// $hora = date("H:i:s");
// echo 'monto:'.$monto;
// echo 'ahora:'.$nuevafecha;

// 	$ini = new DateTime($producto->fechaInicio);
//     $d = new DateTime($producto->fechaFin);
//     $diferencia = $ini->diff($d);
// 		echo '    '.$diferencia->h . 'h </br>';    
// 		echo '    '.$diferencia->i . ' m '; 



    $sentencia = $base_de_datos->prepare("UPDATE carrito SET cantidad =  ?  WHERE id = ?;");
$resultado = $sentencia->execute([ $cantidad,  $idcarrito]);


    $sentencia = $base_de_datos->prepare("UPDATE productos SET tienda = tienda + ?  WHERE id = ?;");
$resultado = $sentencia->execute([ $descontar,  $idproducto]);
 
//echo $idProducto.' -'.$cantidad.'- '.$usuario2 .' -'.$idmesa.' -'.$precio; 

$base_de_datos->commit();
 header("Location: ./venderMesa.php?categoria=".$categoria);
