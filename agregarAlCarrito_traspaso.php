<?php
if (!isset($_POST["codigo"])) {
    return;
}
//id del producto
$codigo = $_POST["codigo"];
$precio = $_POST["precio"];
$cantidad = $_POST["cantidad"];
echo $codigo;
include_once "base_de_datos.php";
$sentencia = $base_de_datos->prepare("SELECT * FROM productos WHERE id = ? ");
$sentencia->execute([$codigo]);
$producto = $sentencia->fetch(PDO::FETCH_OBJ);
# Si no existe, salimos y lo indicamos
if (!$producto) {
    echo 'no existe producto';
    header("Location: ./traspaso.php?status=4");
    exit;
}
# Si no hay tienda...
if ($producto->tienda == 0) {
    header("Location: ./traspaso.php?status=5");
    exit;
}
session_start();
# Buscar producto dentro del cartito
$indice = false;
for ($i = 0; $i < count($_SESSION["carrito"]); $i++) {
    if ($_SESSION["carrito"][$i]->id == $codigo) {
        $indice = $i;
        break;
    }
}
echo 'indicee='.$indice;
# Si no existe, lo agregamos como nuevo
if ($indice === false) {

    if($producto->tienda>=$cantidad){

        $producto->cantidad = $cantidad;
    }else{
        header("Location: ./traspaso.php?status=cantidadsuperada");
        exit;

    } 

    $producto->total = $cantidad* $precio;
    $producto->precioVenta = $precio;
    $producto->descuento=0;
    array_push($_SESSION["carrito"], $producto);
} else {
    # Si ya existe, se agrega la cantidad
    # Pero espera, tal vez ya no haya
    $cantidadExistente = $_SESSION["carrito"][$indice]->cantidad;
    # si al sumarle uno supera lo que existe, no se agrega
    if ($cantidadExistente + $cantidad > $producto->tienda) {
        header("Location: ./traspaso.php?status=5");
        exit;
    }
    if($producto->tienda>$cantidad){
        $_SESSION["carrito"][$indice]->cantidad+=$cantidad;
        
    }else{
        $_SESSION["carrito"][$indice]->cantidad=$producto->tienda;
        
    }
    $_SESSION["carrito"][$indice]->total = $_SESSION["carrito"][$indice]->cantidad * $precio;
    //$_SESSION["carrito"][$indice]->total = $_SESSION["carrito"][$indice]->cantidad * $_SESSION["carrito"][$indice]->precioVenta;
}
echo $_SESSION["carrito"][$indice]->total;
header("Location: ./traspaso.php");
