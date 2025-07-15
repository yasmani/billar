<?php

if(!isset($_POST["indice"])) return;
if(!isset($_POST["descripcion"])) return;

$codigo = $_POST["codigo"];
$indice = $_POST["indice"];
$descripcion = $_POST["descripcion"];
$categoria = $_GET["categoria"];

// echo "codigo=".$codigo."indice=".$indice."  cant=".$cantidad;
include_once "base_de_datos.php";
$sentencia = $base_de_datos->prepare("SELECT * FROM productos WHERE id = ? LIMIT 1;");
$sentencia->execute([$codigo]);
$producto = $sentencia->fetch(PDO::FETCH_OBJ);
  echo $indice;
session_start();
 
 
    
   echo $indice;  
$_SESSION["carrito"][$indice]->descripcion = $descripcion;
 
     header("Location: ./venderTienda.php?categoria=".$categoria);

 