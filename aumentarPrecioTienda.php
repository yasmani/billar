 <?php

if(!isset($_POST["indice"])) return;
if(!isset($_POST["precio"])) return;
if(!isset($_POST["codigo"])) return;

$codigo = $_POST["codigo"];
$indice = $_POST["indice"];
$precio = $_POST["precio"];


//header("Location: ./venderTienda.php");
// echo "codigo=".$codigo."indice=".$indice."  cant=".$cantidad;
include_once "base_de_datos.php";
$sentencia = $base_de_datos->prepare("SELECT * FROM productos WHERE id = ? LIMIT 1;");
$sentencia->execute([$codigo]);
$producto = $sentencia->fetch(PDO::FETCH_OBJ);
 
 
session_start();
# Buscar producto dentro del cartito
//$indice = false;

for ($i = 0; $i < count($_SESSION["carrito"]); $i++) {
    if ($_SESSION["carrito"][$i]->id === $codigo) {
        $indice = $i;
        echo 'entro a indice='.$indice;
    break;
}
}
 
if( $precio<$producto->precioVenta){
    //header("Location: ./venderTienda.php?status=6");

   // echo 'es menor al precio 1 que es '.$precio.' '.$_SESSION["carrito"][$indice]->precioVenta;
    header("Location: ./venderTienda.php?status=6");
   exit;
}
if( $precio>$producto->precioVenta3){
    //echo 'es mayor al precio  '.$producto->precioVenta3;
    header("Location: ./venderTienda.php?status=6");
    exit;
exit;
}
// if(($precio<$_SESSION["carrito"][$indice]->precioVenta ||
// $precio>$_SESSION["carrito"][$indice]->precioVenta3
// )){
// header("Location: ./venderTienda.php?status=6");
// exit;
// }
    $_SESSION["carrito"][$indice]->precioVenta=$precio;
    //$_SESSION["carrito"][$indice]->total = ($_SESSION["carrito"][$indice]->cantidad * $_SESSION["carrito"][$indice]->precioVenta);
    //total redondeado 
    //$totalr=round( ($_SESSION["carrito"][$indice]->cantidad * $_SESSION["carrito"][$indice]->precioVenta), 1, PHP_ROUND_HALF_UP);
    //$_SESSION["carrito"][$indice]->total = $_SESSION["carrito"][$indice]->cantidad * $_SESSION["carrito"][$indice]->precioVenta;
   //round(1.6,0,PHP_ROUND_HALF_UP)
    $totalr=round( ($_SESSION["carrito"][$indice]->cantidad * $_SESSION["carrito"][$indice]->precioVenta)-$_SESSION["carrito"][$indice]->descuento, 2, PHP_ROUND_HALF_UP);
    $_SESSION["carrito"][$indice]->total =$totalr;

echo"<br>";
echo "indice ". $indice;
echo '<br>';
echo "codigop ". $codigo;
echo '<br>';
echo "indice ". $indice;
echo '<br>';
echo "cantidad ". $_SESSION["carrito"][$indice]->cantidad;
echo '<br>';
echo "precio de venta  ". $_SESSION["carrito"][$indice]->precioVenta;
echo '<br>';
echo "total ". $_SESSION["carrito"][$indice]->total;
// header("Location: ./venderTienda.php");

if(isset($_POST["compras"])){
    echo $_POST["compras"];
//header("Location: ./compras.php");
}else{
    header("Location: ./venderTienda.php?status=7");
}
