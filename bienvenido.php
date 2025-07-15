<?php 

session_start();
if(!isset($_COOKIE["usuario"])&&!isset($_COOKIE["password"])){
	header("Location: ./login2.php");
	///echo $_COOKIE["usuario"]; 
}else{
	
	include_once "verificar.php"; 
}
 if($tipo=='administrador'){
include_once "encabezado.php";
}
if($tipo=='cajero'){
include_once "encabezado3.php";
}
if($tipo=='ambulante'){
	include_once "encabezado4.php";
}

if(!isset($_SESSION["carrito"])) $_SESSION["carrito"] = [];
$granTotal = 0;
?>

<?php
include_once "base_de_datos.php";
$sentencia = $base_de_datos->query("SELECT * FROM productos limit 0;");
$productos = $sentencia->fetchAll(PDO::FETCH_OBJ); 
$cantidad=-1;
$descuento=0;
$sentencia = $base_de_datos->query("SELECT * FROM apertura where estado='0';");
$aperturados = $sentencia->fetchAll(PDO::FETCH_OBJ);
$existe=null;
	foreach($aperturados as $producto){ 
	$existe++;
}
?>
<?php
include_once "base_de_datos.php";
  
$sentencia1 = $base_de_datos->query("SELECT * FROM productos WHERE codigo <= 5;");
$products = $sentencia1->fetchAll(PDO::FETCH_OBJ);
$sentencia3 = $base_de_datos->query("SELECT * FROM productos WHERE codigo >=6 and codigo <11;");
$products3 = $sentencia3->fetchAll(PDO::FETCH_OBJ);

?>

<?php
include_once "base_de_datos.php";
  
$sentencia2 = $base_de_datos->query("SELECT * FROM productos WHERE codigo >=16 and codigo <=20;");
$products2 = $sentencia2->fetchAll(PDO::FETCH_OBJ);

$sentencia4 = $base_de_datos->query("SELECT * FROM productos WHERE codigo >=11 and codigo <16;");
$products4 = $sentencia4->fetchAll(PDO::FETCH_OBJ);
?>
 
		 <h1>BIENVENIDO YA PUEDES EMPEZAR A TRABAJAR!!</h1>
	 
                                 
 	 
<?php include_once "pie.php" ?>