<?php

if(!isset($_POST["indice"])) return;
if(!isset($_POST["rebajar"])) return;

$codigo = $_POST["codigo"];
$indice = $_POST["indice"];
$rebajar = $_POST["rebajar"];

// echo "codigo=".$codigo."indice=".$indice."  cant=".$cantidad;
include_once "base_de_datos.php";
$sentencia = $base_de_datos->prepare("SELECT * FROM productos WHERE codigo = ? LIMIT 1;");
$sentencia->execute([$codigo]);
$producto = $sentencia->fetch(PDO::FETCH_OBJ);
 
session_start();
$indice = false;
for ($i = 0; $i < count($_SESSION["carrito"]); $i++) {
    if ($_SESSION["carrito"][$i]->codigo === $codigo) {
        $indice = $i;
    break;
}
}
 
    
     
$_SESSION["carrito"][$indice]->descuento = $rebajar;
$_SESSION["carrito"][$indice]->total = ($_SESSION["carrito"][$indice]->cantidad * $_SESSION["carrito"][$indice]->precioVenta)-$_SESSION["carrito"][$indice]->descuento;
echo"<br>";
echo"<br>";
echo "nombre ". $_SESSION["carrito"][$indice]->descripcion;
echo "cantidad ". $_SESSION["carrito"][$indice]->cantidad;
echo "precio de venta  ". $_SESSION["carrito"][$indice]->precioVenta;
echo "total ". $_SESSION["carrito"][$indice]->total;
     header("Location: ./vender.php");
