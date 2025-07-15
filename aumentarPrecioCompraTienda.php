<?php

if(!isset($_POST["indice"])) return;
if(!isset($_POST["precioCompra"])) return;

$codigo = $_POST["codigo"];
$indice = $_POST["indice"];
$precioCompra = $_POST["precioCompra"];
echo "codigo=".$codigo."<br>";
echo "indice=".$indice."<br>";
echo "precioCompra=".$precioCompra."<br>";

session_start();
$_SESSION["carrito"][$indice]->precioCompra=$precioCompra;
$_SESSION["carrito"][$indice]->total = $_SESSION["carrito"][$indice]->cantidad * $_SESSION["carrito"][$indice]->precioCompra;
echo"<br>";
echo "nombre ". $_SESSION["carrito"][$indice]->descripcion;
echo "cantidad ". $_SESSION["carrito"][$indice]->cantidad;
echo "precio de venta  ". $_SESSION["carrito"][$indice]->precioVenta;
echo "total ". $_SESSION["carrito"][$indice]->total;
// header("Location: ./vender.php");

if(isset($_POST["compras"])){
    // echo $_POST["compras"];
header("Location: ./comprasTienda.php");
}else{
header("Location: ./comprasTienda.php");
}
