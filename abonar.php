<?php

#Salir si alguno de los datos no está presente
if(
	!isset($_POST["codigo"]) || 
	!isset($_POST["monto"])||
	!isset($_POST["id_usuario"])
) exit();
 
 
#Si todo va bien, se ejecuta esta parte del código...

include_once "base_de_datos.php";
date_default_timezone_set("America/La_Paz");

$id_usuario = $_POST["id_usuario"];
$codigo = $_POST["codigo"];
$monto = $_POST["monto"];
$fecha = date("Y-m-d");
$hora = date("H:i:s");
$base_de_datos->beginTransaction();

$sentencia = $base_de_datos->prepare("UPDATE ventastienda SET saldo = saldo+?   WHERE id = ?;");
$resultado = $sentencia->execute([  $monto, $codigo]);

$sentencia = $base_de_datos->prepare("INSERT INTO abonos(id_venta,monto, fecha, hora, usuario) VALUES (?, ?, ?, ?,?);");
$resultado2 = $sentencia->execute([$codigo,$monto, $fecha, $hora,$id_usuario]);
$last_insert=$base_de_datos->lastInsertId();

 

$base_de_datos->commit();

/* En la captura de tu pregunta aparenta estar definido así 'error' */
$error = [ 'id' => $codigo ];
$error = serialize($error);
$error = urlencode($error);

if($resultado === TRUE){
	//header("Location: ./imprimir_creditos_tienda.php?ticket=".$error);
	//exit;
	header("Location: ./imprimir_ventas_creditos_tienda.php?ticket=".$error);
	exit;
}
else echo "Algo salió mal. Por favor verifica que la tabla exista, así como el ID del producto";

?>