<?php
#Salir si alguno de los datos no está presente
if(  !isset($_POST["usuario"]) || !isset($_POST["clave"])  ) 

	exit();

#Si todo va bien, se ejecuta esta parte del código...

include_once "base_de_datos.php";
$usuario = $_POST["usuario"];
$clave = $_POST["clave"];
$tipo = $_POST["tipo"]=='administrador'?"cajero":"ambulante";
 
$imagen='' ;
// $imagen = $_POST["imagen"];
 

echo $imagen;
$sentencia = $base_de_datos->prepare("INSERT INTO usuario(usuario,clave,tipo,ip,condicion) VALUES (?,?,?,?,?);");
$resultado = $sentencia->execute([$usuario,$clave, $tipo,'1','1']);

if($resultado === TRUE){

	header("Location: ./usuarios.php");

	exit;
}
else echo "Algo salió mal. Por favor verifica que la tabla exista";


?>

<!-- <?php include_once "pie.php" ?> -->