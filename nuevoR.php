<?php
#Salir si alguno de los datos no está presente
if(!isset($_POST["codigo"]) || !isset($_POST["descripcion"]) || !isset($_POST["precioVenta"]) || !isset($_POST["precioCompra"]) || !isset($_POST["existencia"])) 

	exit();

#Si todo va bien, se ejecuta esta parte del código...

include_once "base_de_datos.php";
$codigo = $_POST["codigo"];
$nombre = $_POST["nombre"];
$descripcion = $_POST["descripcion"];
$lote = $_POST["lote"];
$precioVenta = $_POST["precioVenta"];
$precio2 = $_POST["precio2"];
$precio3 = $_POST["precio3"];
$precioCompra = $_POST["precioCompra"];
$existencia = $_POST["existencia"];
$tienda = $_POST["tienda"];
$stockminimo = $_POST["stockminimo"];
$imagen='' ;
// $imagen = $_POST["imagen"];
echo $imagen;
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
$sentencia = $base_de_datos->prepare("INSERT INTO productos(codigo,nombre,descripcion,lote, precioVenta,precioVenta2,precioVenta3, precioCompra, existencia,tienda,imagen,stockminimo) VALUES (?,?,?,?,?, ?, ?, ?, ?, ?,?,?);");
$resultado = $sentencia->execute([$codigo,$nombre, $descripcion,$lote, $precioVenta,$precio2,$precio3, $precioCompra, $existencia,$tienda,$imagen,$stockminimo]);

if($resultado === TRUE){

	header("Location: ./formularioR.php");

	exit;
}
else echo "Algo salió mal. Por favor verifica que la tabla exista";


?>

<!-- <?php include_once "pie.php" ?> -->