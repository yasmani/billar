<?php
if(!isset($_GET["indice"])) return;
$indice = $_GET["indice"];

session_start();
array_splice($_SESSION["carrito"], $indice, 1);
if(!isset($_GET["tipo"])){
  header("Location: ./traspaso.php?status=3");

}else{

  header("Location: ./traspaso.php?status=3");
}
?>