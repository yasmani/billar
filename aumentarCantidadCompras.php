<?php

if(!isset($_POST["indice"])) return;
if(!isset($_POST["cantidad"])) return;

$codigo = $_POST["codigo"];
$indice = $_POST["indice"];
$cantidad = $_POST["cantidad"];

// echo "codigo=".$codigo."indice=".$indice."  cant=".$cantidad;
include_once "base_de_datos.php";
$sentencia = $base_de_datos->prepare("SELECT * FROM productos WHERE codigo = ? LIMIT 1;");
$sentencia->execute([$codigo]);
$producto = $sentencia->fetch(PDO::FETCH_OBJ);
# Si no existe, salimos y lo indicamos
// if (!$producto) {
    //     header("Location: ./vender.php?status=4");
    //     exit;
    // }
    # Si no hay existencia...
echo "existencia en la base de datos =".$producto->existencia;
if ($producto->existencia < $cantidad) {
     echo "ho hay existencia";
    // header("Location: ./vender.php?status=cantidadsuperada");
    // exit;
}
session_start();
# Buscar producto dentro del cartito
$indice = false;
for ($i = 0; $i < count($_SESSION["carrito"]); $i++) {
    if ($_SESSION["carrito"][$i]->codigo === $codigo) {
        $indice = $i;
    break;
}
}
# Si no existe, lo agregamos como nuevo
if ($indice === false) {
    $producto->cantidad =0;
    $producto->total = $producto->precioVenta;
    array_push($_SESSION["carrito"], $producto);
} else {
    # Si ya existe, se agrega la cantidad
    # Pero espera, tal vez ya no haya
    $cantidadExistente = $_SESSION["carrito"][$indice]->cantidad;
    # si al sumarle uno supera lo que existe, no se agrega
    // if ($cantidad > $producto->existencia) {
    //     header("Location: ./vender.php?status=5");
    //     exit;
    // }
    // $totalr=round( ($_SESSION["carrito"][$indice]->cantidad * $_SESSION["carrito"][$indice]->precioVenta), 0, PHP_ROUND_HALF_UP);
    // $_SESSION["carrito"][$indice]->total =$totalr;

    $_SESSION["carrito"][$indice]->cantidad=$cantidad;
    $_SESSION["carrito"][$indice]->total = $_SESSION["carrito"][$indice]->cantidad * $_SESSION["carrito"][$indice]->precioCompra;
}
echo"<br>";
echo "nombre ". $_SESSION["carrito"][$indice]->descripcion;
echo "cantidad ". $_SESSION["carrito"][$indice]->cantidad;
echo "precio de venta  ". $_SESSION["carrito"][$indice]->precioVenta;
echo "total ". $_SESSION["carrito"][$indice]->total;
// header("Location: ./vender.php");

if(isset($_POST["compras"])){
    // echo $_POST["compras"];
header("Location: ./compras.php");
}else{
header("Location: ./vender.php");
}
