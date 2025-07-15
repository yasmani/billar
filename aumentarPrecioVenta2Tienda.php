<?php

if(!isset($_POST["indice"])) return;
if(!isset($_POST["precioVenta"])) return;

$codigo = $_POST["codigo"];
$indice = $_POST["indice"];
$precioVenta = $_POST["precioVenta"];
echo "codigo=".$codigo."<br>";
echo "indice=".$indice."<br>";
echo "precioVenta=".$precioVenta."<br>";
// echo "codigo=".$codigo."indice=".$indice."  cant=".$cantidad;
include_once "base_de_datos.php";
$sentencia = $base_de_datos->prepare("SELECT * FROM productos WHERE codigo = ? LIMIT 1;");
$sentencia->execute([$codigo]);
$producto = $sentencia->fetch(PDO::FETCH_OBJ);
session_start();
$_SESSION["carrito"][$indice]->precioVenta2=$precioVenta;
echo"<br>";
echo "nombre ". $_SESSION["carrito"][$indice]->descripcion;
echo "cantidad ". $_SESSION["carrito"][$indice]->cantidad;
echo "precio de venta  ". $_SESSION["carrito"][$indice]->precioVenta2;
echo "total ". $_SESSION["carrito"][$indice]->total;
// header("Location: ./vender.php");

if(isset($_POST["compras"])){
    // echo $_POST["compras"];
header("Location: ./comprasTienda.php");
}else{
// header("Location: ./vender.php");
}
