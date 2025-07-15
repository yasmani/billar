<?php

#Salir si alguno de los datos no está presente
if(
	!isset($_POST["id"])
) exit();
 
 
#Si todo va bien, se ejecuta esta parte del código...

include_once "base_de_datos.php";
$id = $_POST["id"];
$tipo = $_POST["tipo"];
 $id_cliente = $_POST["id_cliente"];
 
$sentencia = $base_de_datos->prepare("UPDATE ventastienda SET tipoDeVenta = ? WHERE id = ?;");
$resultado = $sentencia->execute([$tipo , $id]);

if($resultado === TRUE){
	header("Location: ./verventas.php?cliente=".$id_cliente);
	//exit;
}
else echo "Algo salió mal. Por favor verifica que la tabla exista, así como el ID ";
?>