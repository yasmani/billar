<?php

#Salir si alguno de los datos no está presente
if(
	!isset($_POST["codigo"]) || 
	!isset($_POST["nombre"]) || 
	!isset($_POST["descripcion"]) || 
	!isset($_POST["lote"]) || 
	!isset($_POST["precioCompra"]) || 
	!isset($_POST["precioVenta"]) || 
	!isset($_POST["precioVenta2"]) || 
	!isset($_POST["precioVenta3"]) || 
	!isset($_POST["existencia"]) || 
	!isset($_POST["tienda"]) || 
	!isset($_POST["id"])
) exit();
$imagen='' ;
if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name']))
		{
			$imagen=$_POST["imagenactual"];
		}
		else 
		{
			$ext = explode(".", $_FILES["imagen"]["name"]);
			if ($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png")
			{
				$imagen = round(microtime(true)) . '.' . end($ext);
				move_uploaded_file($_FILES["imagen"]["tmp_name"], "files/articulos/" . $imagen);
			}
		}
		echo $imagen;
 
#Si todo va bien, se ejecuta esta parte del código...

include_once "base_de_datos.php";
$id = $_POST["id"];
$codigo = $_POST["codigo"];
$nombre = $_POST["nombre"];
$descripcion = $_POST["descripcion"];
$lote = $_POST["lote"];
$precioCompra = $_POST["precioCompra"];
$precioVenta = $_POST["precioVenta"];
$precioVenta2 = $_POST["precioVenta2"];
$precioVenta3 = $_POST["precioVenta3"];
$existencia = $_POST["existencia"];
$tienda = $_POST["tienda"];
$stockminimo = $_POST["stockminimo"];
$especial = $_POST["especial"];

$sentencia = $base_de_datos->prepare("UPDATE productos SET codigo = ?, nombre = ?, descripcion = ?,lote = ?, precioCompra = ?, precioVenta = ?, precioVenta2 = ?, precioVenta3 = ?, existencia = ?,tienda = ?, imagen = ?, stockminimo = ? , titulo = ? WHERE id = ?;");
$resultado = $sentencia->execute([$codigo, $nombre,$descripcion,$lote, $precioCompra, $precioVenta,$precioVenta2,$precioVenta3, $existencia,$tienda,$imagen,$stockminimo, $especial,$id]);

if($resultado === TRUE){
	header("Location: ./listar-inventario_tienda.php");
	exit;
}
else echo "Algo salió mal. Por favor verifica que la tabla exista, así como el ID del producto";
?>