<?php
if (!isset($_POST["codigo"])) {
    return;
}

$codigo = $_POST["codigo"];
include_once "base_de_datos.php";
$sentencia = $base_de_datos->prepare("SELECT * FROM productos WHERE id = ? LIMIT 1;");
$sentencia->execute([$codigo]);
$producto = $sentencia->fetch(PDO::FETCH_OBJ);
# Si no existe, salimos y lo indicamos
if (!$producto) {
    header("Location: ./compras.php?status=no-existe");
    exit;
}
 
session_start();
# Buscar producto dentro del cartito
$indice = false;
for ($i = 0; $i < count($_SESSION["carrito"]); $i++) {
    if ($_SESSION["carrito"][$i]->id === $codigo) {
        $indice = $i;
        break;
    }
}
# Si no existe, lo agregamos como nuevo
if ($indice === false) {
    $producto->cantidad = 1;
    $producto->descuento=0;
    $producto->total = $producto->precioCompra;
    array_push($_SESSION["carrito"], $producto);
} else {
    
    $_SESSION["carrito"][$indice]->cantidad++;
    $_SESSION["carrito"][$indice]->total = $_SESSION["carrito"][$indice]->cantidad * $_SESSION["carrito"][$indice]->precioCompra;
}
// echo $_SESSION["carrito"][$indice]->codigo.'<br>';

// echo $_SESSION["carrito"][$indice]->descripcion.'<br>';

// echo $_SESSION["carrito"][$indice]->precioVenta.'<br>';
 
// echo $_SESSION["carrito"][$indice]->precioCompra.'<br>';
 
// echo $_SESSION["carrito"][$indice]->cantidad.'<br>';
 
header("Location: ./compras.php");
