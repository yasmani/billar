<?php
if(!isset($_GET["id"])) exit();
$id = $_GET["id"];
$idproducto = $_GET["idproducto"];
$cantidad = $_GET["cantidad"];
$categoria = $_GET["categoria"];
include_once "base_de_datos.php";
$sentencia = $base_de_datos->prepare("DELETE FROM carrito WHERE id = ?;");
$resultado = $sentencia->execute([$id]);

   $sentencia22 = $base_de_datos->prepare("UPDATE productos SET tienda = tienda + ?  WHERE id = ?;");
      $sentencia22->execute([$cantidad,  $idproducto]);
     
      
      $sentencia3 = $base_de_datos->prepare("DELETE FROM pausas_billar WHERE id_carrito = ?;");
      $resultado2 = $sentencia3->execute([$id]);
      
echo $id;
if($resultado === TRUE){
 	header("Location: ./venderMesa.php?categoria=".$categoria);
 	exit;
}
else echo "Algo salió mal";
?>