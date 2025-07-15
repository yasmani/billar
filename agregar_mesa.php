<?php
#Salir si alguno de los datos no está presente
include_once "base_de_datos.php";
$id = $_REQUEST["id"];
$usuario = $_REQUEST["idusuario"];

$base_de_datos->beginTransaction();
$sentencia = $base_de_datos->prepare("DELETE FROM atencion WHERE usuario = ?;");
$resultado = $sentencia->execute([$usuario]);

$sentencia = $base_de_datos->prepare("UPDATE mesa SET condicion = '1'   WHERE id = ?;");
$resultado = $sentencia->execute([  $id]);

$sentencia = $base_de_datos->prepare("INSERT INTO atencion(idmesa, usuario) VALUES (?, ?);");
$resultado2 = $sentencia->execute([$id,$usuario  ]);
$last_insert=$base_de_datos->lastInsertId();

$base_de_datos->commit();
header("Location: ./venderMesa.php ");
	exit;
?>
