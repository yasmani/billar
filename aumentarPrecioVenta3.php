<?php

if(!isset($_POST["indice"])) return;
if(!isset($_POST["precioVenta"])) return;

$codigo = $_POST["codigo"];
$indice = $_POST["indice"];
$precioVenta = $_POST["precioVenta"];

include_once "base_de_datos.php";
$sentencia = $base_de_datos->prepare("SELECT * FROM productos WHERE codigo = ? LIMIT 1;");
$sentencia->execute([$codigo]);
$producto = $sentencia->fetch(PDO::FETCH_OBJ);
session_start();
$_SESSION["carrito"][$indice]->precioVenta3=$precioVenta;
if(isset($_POST["compras"])){
header("Location: ./compras.php");
}else{
}
