<?php
if(!isset($_GET["indice"])) return;
$indice = $_GET["indice"];
$categoria = $_GET["categoria"];

session_start();
array_splice($_SESSION["carrito"], $indice, 1);
if(!isset($_GET["tipo"])){
  header("Location: ./compras.php?status=3");

}else{

  header("Location: ./venderTienda.php?status=3"."&&categoria=" .$categoria);
}
?>