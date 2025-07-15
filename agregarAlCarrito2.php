 <?php
if (!isset($_POST["codigo"])) {
    return;
}

$codigo = $_POST["codigo"];

include_once "base_de_datos.php";
$sentencia = $base_de_datos->prepare("SELECT * FROM productos WHERE codigo = ? LIMIT 1;");
$sentencia->execute([$codigo]);
$producto = $sentencia->fetch(PDO::FETCH_OBJ);
# Si no existe, salimos y lo indicamos
if (!$producto) {
    header("Location: ./venderTienda.php?status=4");
    exit;
}
# Si no hay existencia...
if ($producto->tienda == 0) {
    header("Location: ./venderTienda.php?status=5");
    exit;
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

    if($producto->tienda>1){

        $producto->cantidad = 1;
    }else{
        $producto->cantidad = $producto->tienda;

    }
    $producto->total = $producto->precioVenta;
    $producto->descuento=0;
    array_push($_SESSION["carrito"], $producto);
} else {
    # Si ya existe, se agrega la cantidad
    # Pero espera, tal vez ya no haya
    $cantidadExistente = $_SESSION["carrito"][$indice]->cantidad;
    # si al sumarle uno supera lo que existe, no se agrega
    if ($cantidadExistente + 1 > $producto->tienda) {
        header("Location: ./venderTienda.php?status=5");
        exit;
    }
    if($producto->tienda>1){
        $_SESSION["carrito"][$indice]->cantidad++;
        
    }else{
        $_SESSION["carrito"][$indice]->cantidad=$producto->tienda;
        
    }
    $_SESSION["carrito"][$indice]->total = $_SESSION["carrito"][$indice]->cantidad * $_SESSION["carrito"][$indice]->precioVenta;
}
header("Location: ./venderTienda.php");
