 <?php

if(!isset($_POST["indice"])) return;
if(!isset($_POST["cantidad"])) return;

$codigo = $_POST["codigo"];
$indice = $_POST["indice"];
$cantidad = $_POST["cantidad"];
include_once "base_de_datos.php";
$sentencia = $base_de_datos->prepare("SELECT * FROM productos WHERE id = ? LIMIT 1;");
$sentencia->execute([$codigo]);
$producto = $sentencia->fetch(PDO::FETCH_OBJ);
echo "tienda en la base de datos =".$producto->tienda;
if ($producto->tienda < $cantidad) {
    header("Location: ./traspaso.php?status=cantidadsuperada");
    exit;
}
session_start();
# Buscar producto dentro del cartito
//$indice = false;
for ($i = 0; $i < count($_SESSION["carrito"]); $i++) {
    if ($_SESSION["carrito"][$i]->id === $codigo) {
        $indice = $i;
    break;
}
}
# Si no existe, lo agregamos como nuevo
if ($indice === false) {
    
} else {
    # Si ya existe, se agrega la cantidad
    # Pero espera, tal vez ya no haya
    $cantidadExistente = $_SESSION["carrito"][$indice]->cantidad;
    # si al sumarle uno supera lo que existe, no se agrega
    if ($cantidad > $producto->tienda) {
        header("Location: ./traspaso.php?status=5");
        exit;
    }
    $_SESSION["carrito"][$indice]->cantidad=$cantidad;
    $_SESSION["carrito"][$indice]->total = ($_SESSION["carrito"][$indice]->cantidad * $_SESSION["carrito"][$indice]->precioVenta)-$_SESSION["carrito"][$indice]->Descuento;
    //total redondeado 
    //$totalr=round( ($_SESSION["carrito"][$indice]->cantidad * $_SESSION["carrito"][$indice]->precioVenta), 1, PHP_ROUND_HALF_UP);
    //$_SESSION["carrito"][$indice]->total = $_SESSION["carrito"][$indice]->cantidad * $_SESSION["carrito"][$indice]->precioVenta;
   //round(1.6,0,PHP_ROUND_HALF_UP)
    $totalr=round( ($_SESSION["carrito"][$indice]->cantidad * $_SESSION["carrito"][$indice]->precioVenta), 2, PHP_ROUND_HALF_UP);
    $_SESSION["carrito"][$indice]->total =$totalr;
}
 

if(isset($_POST["compras"])){
    // echo $_POST["compras"];
header("Location: ./compras.php");
}else{
header("Location: ./traspaso.php");
}
