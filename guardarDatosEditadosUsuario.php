<?php

#Salir si alguno de los datos no está presente
if(
	!isset($_POST["usuario"]) || 
	!isset($_POST["clave"]) || 
	!isset($_POST["tipo"]) || 
	!isset($_POST["id"])
) exit();
 
 
#Si todo va bien, se ejecuta esta parte del código...

include_once "base_de_datos.php";
$id = $_POST["id"];
$usuario = $_POST["usuario"];
$clave = $_POST["clave"];
$tipo = $_POST["tipo"];
 

$sentencia = $base_de_datos->prepare("UPDATE usuario SET usuario = ?, clave = ?, tipo = ? WHERE id = ?;");
$resultado = $sentencia->execute([$usuario, $clave,$tipo, $id]);

if($resultado === TRUE){
	header("Location: ./usuarios.php");
	exit;
}
else echo "Algo salió mal. Por favor verifica que la tabla exista, así como el ID ";
?>