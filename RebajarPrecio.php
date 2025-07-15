<?php

if(!isset($_POST["indice"])) return;
if(!isset($_POST["rebajar"])) return;

$codigo = $_POST["codigo"];
$indice = $_POST["indice"];
$rebajar = $_POST["rebajar"];

// echo "codigo=".$codigo."indice=".$indice."  cant=".$cantidad;
include_once "base_de_datos.php";
$sentencia = $base_de_datos->prepare("SELECT * FROM productos WHERE id = ? LIMIT 1;");
$sentencia->execute([$codigo]);
$producto = $sentencia->fetch(PDO::FETCH_OBJ);
  echo $indice;
session_start();
 
 
    
   echo $indice;  
$_SESSION["carrito"][$indice]->descuento = $rebajar;
$_SESSION["carrito"][$indice]->total = ($_SESSION["carrito"][$indice]->cantidad * $_SESSION["carrito"][$indice]->precioVenta)-$_SESSION["carrito"][$indice]->descuento;
 
     header("Location: ./vender.php");

 